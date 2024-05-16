<?php

namespace App\Services;

use App\Models\ResponseRecord;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MQTTService
{
    public static function sendResponse($response_record_id)
    {
        $r = ResponseRecord::with('status_record.status')->find($response_record_id);
        $content["status_record_id"] = $r->status_record_id;
        $content["employee_code"] = $r->employee_code;
        $content["error_code"] = $r->status_record->status->code ?? '';
        $content["error_name"] = $r->status_record->status->name ?? '';
        $content["response_option"] = $r->response_option;
        $content["segment_code"] = $r->status_record->segment_code;
        $content["machine_code"] =  $r->status_record->machine_code;
        $content["message"] = $r->employee_code . " - " . $r->response_option;

        try {
            MQTT::publish(TOPIC_RESPONSE, json_encode($content));
            MQTT::disconnect();
        } catch (Exception $e) {
            Log::error('sendResponse() ' . $e);
        }
    }
}
