<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\GetLatestRequest;
use App\Http\Requests\Api\PostLoginRequest;
use App\Http\Requests\Api\PostResolveRequest;
use App\Http\Requests\Api\PostResponseRequest;
use App\Http\Requests\Api\PostStatusRequest;
use App\Models\ResponseRecord;
use App\Models\Status;
use App\Models\StatusRecord;
use App\Models\User;
use App\Models\Watch;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;


class WatchController extends ApiController
{
    public function postLogin(PostLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('username', $data['employee_code'])->where('user_type', OPERATOR)->first(['id', 'username', 'shift']);
        if ($user == null) return response()->json(['message' => 'Employee not found'], 400);

        $watch = Watch::where('code', $data['watch_code'])->first();
        if ($watch) {
            $watch->login_user_id = $user->id;
            $watch->login_at = Carbon::now();
            $watch->save();
        }

        return response()->json($user->append('group_ids')->makeHidden(['menu_flags', 'groups']));
    }

    /**
     * Return the latest record 
     */
    public function getLatestMachineRecord($employee_code)
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
            if ($response->attending) return response()->json(['message' => $response->employee_code . ' already accepted this task.']);
        }

        //Append ResponseRecord Data
        $data['attending'] = ($record->status->button_1 == $data['response_option']) ? true : false;
        $data['response_duration_second'] = $now->diffInSeconds($record->created_at);
        ResponseRecord::create($data);

        return response()->json(['message' => 'Success']);
    }
}
