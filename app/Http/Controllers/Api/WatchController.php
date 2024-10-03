<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PostCompleteRequest;
use App\Http\Requests\Api\PostLoginRequest;
use App\Http\Requests\Api\PostLogoutRequest;
use App\Http\Requests\Api\PostResponseRequest;
use App\Models\ResponseRecord;
use App\Models\Segment;
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

        $user = User::where('username', $data['employee_code'])->first(['id', 'username', 'shift']);
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
            if ($response->attending) {
                if ($response->employee_code == $data['employee_code']) {
                    //Watch sometime will post twice, if same employee will return success, so the watch able to record and go complete job page.
                    return response()->json(['message' => 'Success']);
                } else {
                    return response()->json(['message' => $response->employee_code . ' is attending.']);
                }
            }
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

    /**
     * When operator update job complete
     */
    public function postComplete(PostCompleteRequest $request)
    {
        //Look for the person that accept the job
        $sr = StatusRecord::with('attending')->whereNull('completed_at')->find($request->status_record_id);
        if ($sr) {
            if ($sr->attending == null)
                return response()->json(['message' => 'No one accepted the job.']);

            $now = Carbon::now();
            $sr->completed_at = $now;
            $sr->complete_duration_second = $now->diffInSeconds($sr->created_at);
            $sr->save();

            MQTTService::sendComplete($sr->id);
        } else {
            return response()->json(['message' => 'Job has been completed.']);
        }
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

        //Check is the user currently handling other job?
        $onGoingJob = StatusRecord::with('attending')
            ->whereHas('attending', function ($q) use ($employee_code) {
                $q->where('employee_code', $employee_code);
            })->whereNull('completed_at')
            ->where('created_at', ">=", Carbon::now()->subMinute(JOB_COMPLETE_AFTER_MINUTE))
            ->orderBy('created_at', 'desc')->first();

        if ($onGoingJob) return response()->json(null); //Do not notify the user

        $group_query = [];
        foreach ($user->groups as $group) {
            $group_query[] = ['segment_code' => $group->segment_code, 'machine_types' => $group->machine_list];
        }

        //Only selected needed field, IOT watch can't support too many string
        $record = StatusRecord::select('id', 'machine_code', 'segment_code', 'status_id')
            ->with('segment')
            ->with(['status'])->ofUserGroup($group_query)
            ->ofIsNew()
            ->ofSelfNoResponse($employee_code)
            ->where('created_at', ">=", Carbon::now()->subMinute(LATEST_RECORD_VIEW_MINUTE)) //Only show message that is within 15min, if no longer no longer appear
            ->orderBy('created_at', 'desc')->first();

        if ($record) {
            $record->segment_name = $record->segment_code;
            if ($record->segment != null) {
                $record->segment_name = $record->segment->name;
                unset($record->segment); //Reduce showing too much data in watch
            }
        }
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
        $timezoneOffset = Carbon::now()->format("P");
        list($hours, $minutes) = sscanf($timezoneOffset, '%d:%d');
        $offsetInSeconds = ($hours * 3600) + ($minutes * 60);
        $data['timezone'] = $offsetInSeconds;
        $data['local'] = Carbon::now()->getTimestamp() + $offsetInSeconds;
        $data['utc'] = Carbon::now()->getTimestamp();


        return response()->json($data);
    }

    public function getTest()
    {
        return response()->json(['message' => 'OK']);
    }
}
