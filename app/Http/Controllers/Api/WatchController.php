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


class WatchController extends ApiController
{
    public function getStatus(GetStatusRequest $request)
    {
        $data = $request->validated();
        $record = StatusRecord::with(['status', 'responses'])->ofMachine($data)
            ->orderBy('created_at', 'desc')->first();

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
