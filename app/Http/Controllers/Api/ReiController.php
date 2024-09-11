<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\GetLastRequest;
use App\Http\Requests\Api\PostCodeRequest;
use App\Http\Requests\Api\PostStatusRequest;
use App\Models\ResponseRecord;
use App\Models\Status;
use App\Models\StatusRecord;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;


class ReiController extends ApiController
{

    public function getStatuses()
    {
        return Status::select(['id', 'code', 'name', 'state', 'button_1', 'button_2'])->where('active', true)->get();
    }

    public function getLastMachineRecord(GetLastRequest $request)
    {
        $data = $request->validated();
        $record = StatusRecord::with(['status', 'responses'])->ofMachine($data)
            ->orderBy('created_at', 'desc')->first();

        return response()->json($record);
    }

    /**
     * REI Send one of the ERROR / Warning Status
     */
    public function postStatus(PostStatusRequest $request)
    {
        $data = $request->validated();
        $data['origin'] = REI;

        //REI incoming username is USER#0000, separate it to employee_name and employee_code field.
        $emp = explode("#", $data['employee_code']);
        if (count($emp) == 2) {
            $data['employee_name'] = $emp[0];
            $data['employee_code'] = $emp[1];
        }

        //Within 60 sec, assume they want to change the error / warning status, so do update
        $record = StatusRecord::ofMachine($data)->where('created_at', '>=', Carbon::now()->subSeconds(60))->orderBy('created_at', 'desc')->first();
        if ($record) {
            $record->update($data);
            $output = StatusRecord::with('status')->find($record->id);
        } else {
            $created = StatusRecord::create($data);
            $output = StatusRecord::with('status')->find($created->id);
        }


        return response()->json($output);
    }

    /**
     * When operator infront of the machine and press "LOCAL" button
     */
    public function postLatestAttend(PostCodeRequest $request)
    {
        $data = $request->validated();

        $now = Carbon::now();
        $record = StatusRecord::ofMachine($data)
            ->whereNull('attended_at')->orderBy('created_at', 'desc')->firstOrFail();

        $record->attended_at = $now;
        $record->attend_duration_second = $now->diffInSeconds($record->created_at);
        $record->save();

        return response()->json(['message' => 'Success']);
    }

    /**
     * When Towerlight turn back to Green, call postLatestResolve
     */
    public function postLatestResolve(PostCodeRequest $request)
    {
        $data = $request->validated();

        $now = Carbon::now();
        $record = StatusRecord::ofMachine($data)
            ->whereNull('resolved_at')->orderBy('created_at', 'desc')->firstOrFail();

        $record->resolved_at = $now;
        $record->resolve_duration_second = $now->diffInSeconds($record->created_at);
        $record->save();

        return response()->json(['message' => 'Success']);
    }
}
