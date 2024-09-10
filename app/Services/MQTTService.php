<?php

namespace App\Services;

use App\Models\ResponseRecord;
use App\Models\Watch;
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
        $content["message"] = $r->employee_name . " - " . $r->response_option;
        $content["response_yes"] = $r->attending;

        try {
            MQTT::publish(TOPIC_RESPONSE, json_encode($content));
            MQTT::disconnect();
        } catch (Exception $e) {
            Log::error('sendResponse() ' . $e);
        }
    }

    /*
    * Send to watch and watch will trigger POST: /watch/login
    */
    public static function sendLogin(Watch $watch, $mode)
    {
        $content['employee_code'] = $watch->login_user->username;
        $content['login_mode'] = $mode; //WEB OR BADGE;
        try {
            MQTT::publish(TOPIC_LOGIN . "/" . $watch->code, json_encode($content));
            MQTT::disconnect();
        } catch (Exception $e) {
            Log::error('sendLogin() ' . $e);
        }
    }

    public static function sendTest()
    {
        $content['message'] = "Hello World";
        MQTT::publish("andon/test", json_encode($content));
        MQTT::disconnect();
    }
}
