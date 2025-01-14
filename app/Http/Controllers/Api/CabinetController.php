<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PostCompleteRequest;
use App\Http\Requests\Api\PostLoginRequest;
use App\Http\Requests\Api\PostLogoutRequest;
use App\Http\Requests\Api\PostOperationRequest;
use App\Http\Requests\Api\PostResponseRequest;
use App\Models\ApiLog;
use App\Models\Cabinet;
use App\Models\ResponseRecord;
use App\Models\Segment;
use App\Models\StatusRecord;
use App\Models\User;
use App\Models\Watch;
use App\Models\WatchLoginLog;
use App\Services\MQTTService;
use Carbon\Carbon;
use Illuminate\Http\Request;


/**
 * This is for Cabinet related API, connect to China Manufacturer Smart Charging Cabinet
 */
class CabinetController extends ApiController
{
    /**
     * They will call this every 30min to get latest user info
     */
    public function getStaff(Request $request)
    {
        $data = [];
        $output = ["code" => "20000", "message" => "ok", "data" => []];

        $users =  User::select('name', 'username', 'badge_no', 'user_type', 'active')->get();

        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $staff = [
                    'staff_name' => $user->name,
                    'department' => 'DAVINCI',
                    'cost_centre' => 'MS1022', //TODO: create a master file, temporary only one cost centre
                    'staff_id' => $user->username,
                    'accard_id' => intval($user->badge_no),
                ];

                //If true, this operator can use setup function
                if ($user->user_type == ADMIN) {
                    $staff['markAsAdmin'] = true;
                }

                //If true, this operator can use this cabinet
                if ($user->active) {
                    $staff['markAsAuthed'] = true;
                }

                $data[] = $staff;
            }
        }

        $output['data'] = $data;
        return response()->json($output);
    }


    public function postOperation(PostOperationRequest $request)
    {
        $data = $request->validated();
        $this->storeLog($request);

        $user = User::where('username', $data['staffId'])->first();
        Cabinet::updateOrCreate(
            ['box_id' => $data['boxId']], // Search criteria
            [
                'box_id' =>  $data['boxId'],
                'box_no' => $data['boxNo'],
                'status' => $data['operation'],
                'last_occur_at' => $data['occurAt'],
                'last_operate_user_id' => $user->id,
            ] // Update or create with these values
        );

        $output = ["code" => "20000", "message" => "ok"];
        return response()->json($output);
    }

    private function storeLog($request)
    {
        ApiLog::create(
            [
                'url' => $request->url(),
                'header' => json_encode($request->header()),
                'payload' => json_encode($request->all()),
            ]
        );
    }
}
