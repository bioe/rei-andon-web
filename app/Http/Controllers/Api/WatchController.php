<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PostLoginRequest;
use App\Http\Requests\Api\PostLogoutRequest;
use App\Http\Requests\Api\PostResponseRequest;
use App\Models\ResponseRecord;
use App\Models\StatusRecord;
use App\Models\User;
use App\Models\Watch;
use App\Models\WatchLoginLog;
use App\Services\MQTTService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WatchController extends ApiController
{
    public function postLogin(PostLoginRequest $request)
    {
        $data = $request->validated();

        $log = WatchLoginLog::ofPending()->whereHas('watch', function ($q) use ($data) {
            $q->where('code', $data['watch_code']);
        })->whereHas('user', function ($q) use ($data) {
            $q->where('username', $data['employee_code']);
        })->orderBy('created_at', 'desc')->first();

        if (isset($data['cancel']) && $data['cancel']) {
            $log->cancel = true;
            $log->save();
            return response()->json(['message' => 'Login Cancelled']);
        }

        $user = User::where('username', $data['employee_code'])->where('user_type', OPERATOR)->first(['id', 'username', 'shift']);
        if ($user == null) return response()->json(['message' => 'Employee not found'], 400);

        if ($log) {
            $log->success = true;
            $log->login_at = Carbon::now();
            $log->save();
            $log->updateWatch();

            return response()->json($user->append('group_ids')->makeHidden(['menu_flags', 'groups']));
        } else {
            return response()->json(['message' => 'Login invalid'], 400);
        }
    }

    public function postLogout(PostLogoutRequest $request)
    {
        $data = $request->validated();

        $watch = Watch::where('code', $data['watch_code'])->first();
        if ($watch) {
            $watch->login_user_id = null;
            $watch->login_at = null;
            $watch->save();
        } else {
            return response()->json(['message' => 'Watch not found.'], 400);
        }

        $log = WatchLoginLog::toLogout()->whereHas('watch', function ($q) use ($data) {
            $q->where('code', $data['watch_code']);
        })->orderBy('created_at', 'desc')->first();

        if ($log) {
            $log->logout_at = Carbon::now();
            $log->save();
        }

        return response()->json(['message' => 'Success']);
    }

    /**
     * Return the selected record 
     */
    public function getRecord($id)
    {
        $record = StatusRecord::with(['status', 'responses'])->find($id);
        return response()->json($record);
    }

    /**
     * When Operator click one of the button from Watch
     */
    public function postResponse(PostResponseRequest $request)
    {
        $data = $request->validated();
        $now = Carbon::now();

        $record = StatusRecord::with(['status', 'responses'])->findOrFail($data['status_record_id']);

        foreach ($record->responses as $response) {
            if ($response->attending) return response()->json(['message' => $response->employee_code . ' is attending.']);
        }

        //Try to get Employee name
        $user = User::where("username", $data['employee_code'])->first();
        if ($user) $data['employee_name'] = $user->name;

        //Append ResponseRecord Data
        $data['attending'] = ($record->status->button_1 == $data['response_option']) ? true : false;
        $data['response_duration_second'] = $now->diffInSeconds($record->created_at);
        $rr = ResponseRecord::create($data);

        MQTTService::sendResponse($rr->id);

        return response()->json(['message' => 'Success']);
    }


    //Polling method, if not using MQTT

    /**
     * Return the latest record 
     */
    public function getPollLatestMachineRecord($employee_code)
    {
        //Check user and determine which record to show
        $user = User::with('groups')->where('username', $employee_code)->first();
        if ($user == null) return response()->json(null);

        $group_query = [];
        foreach ($user->groups as $group) {
            $group_query[] = ['segment_code' => $group->segment_code, 'machine_types' => $group->machine_list];
        }

        //Only selected needed field, IOT watch can't support too many string
        $record = StatusRecord::select('id', 'machine_code', 'segment_code', 'status_id')->with(['status'])->ofUserGroup($group_query)
            ->ofIsNew()
            ->ofSelfNoResponse($employee_code)
            ->where('created_at', ">=", Carbon::now()->subMinute(LATEST_RECORD_VIEW_MINUTE)) //Only show message that is within 15min, if no longer no longer appear
            ->orderBy('created_at', 'desc')->first();

        return response()->json($record);
    }

    /**
     * Let watch check any one is trying to login > watch will prompt a confirmation box > postLogin
     */
    public function getPollLogin(Request $request, $watch_code)
    {
        $log = WatchLoginLog::with('user')->ofPending()->whereHas('watch', function ($q) use ($watch_code) {
            $q->where('code', $watch_code);
        })->first();

        if ($log)
            return response()->json([
                'employee_code' => $log->user->username,
                'login_mode' => WATCH_LOGIN_WEB,
                'timeout_second' => (config('setting.watch_login_timeout') - 2) //Login Window Appear for how many seconds
            ]);

        return response()->json(null);
    }

    public function getTime()
    {
        //Dummy data for the watch copy from https://api.openweathermap.org/data/2.5/weather?id=1733047&appid=a3a7aa927cd7d078588de12cb9d220f3
        // $data['coord'] = ['lon' => 100.2585, 'lat' => 5.3768];
        // $data['weather'] = [
        //     ['id' => 801, 'main' => "Clouds", 'description' => 'few clouds', 'icon' => '02d']
        // ];
        // $data['base'] = 'stations';
        // $data['main'] = [
        //     'temp' => 301.25,
        //     'feels_like' => 301.25,
        //     'temp_min' => 301.25,
        //     'temp_max' => 301.25,
        //     'pressure' => 1000,
        //     'humidity' => 70,
        //     'sea_level' => 1008,
        //     'grnd_level' => 958
        // ];
        // $data['visibility'] = 10000;
        // $data['wind'] = ['speed' => 2.06, 'deg' => 0];
        // $data['cloud'] = ['all' => 100];
        // $data['id'] = 1;
        // $data['name'] = "Penang";
        // $data['code'] = 200;
        // //Dynamic Data

        // $data['sys'] = [
        //     "type" => 1,
        //     "id" => 9438,
        //     "country" => "MY",
        //     "sunrise" => Carbon::now()->getTimestamp(),
        //     "sunset" => Carbon::now()->getTimestamp()
        // ];
        $data['dt'] = Carbon::now()->getTimestamp();
        $timezoneOffset = Carbon::now()->format("P");
        list($hours, $minutes) = sscanf($timezoneOffset, '%d:%d');
        $offsetInSeconds = ($hours * 3600) + ($minutes * 60);
        $data['timezone'] = $offsetInSeconds;

        return response()->json($data);
    }

    public function getTest()
    {
        return response()->json(['message' => 'OK']);
    }
}
