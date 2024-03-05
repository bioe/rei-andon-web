<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\GetStatusRequest;
use App\Http\Requests\Api\PostResolveRequest;
use App\Http\Requests\Api\PostResponseRequest;
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

    public function getStatus(GetStatusRequest $request)
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
        //Within 15 sec, assume they want to change the error / warning status, so do update
        $record = StatusRecord::ofMachine($data)->where('created_at', '>=', Carbon::now()->subSeconds(15))->first();
        if ($record) {
            $record->update($data);
            $output = StatusRecord::ofMachine($data)->first();
        } else {
            $output = StatusRecord::create($data);
        }


        return response()->json($output);
    }

    /**
     * When operator infront of the machine and press "LOCAL" button
     */
    public function postAttend(PostResolveRequest $request)
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
     * When Towerlight turn back to Green, call postResolve
     */
    public function postResolve(PostResolveRequest $request)
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
