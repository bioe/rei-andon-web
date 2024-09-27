<?php

namespace App\Services;

use App\Models\ResponseRecord;
use App\Models\StatusRecord;
use App\Models\Watch;
use App\Models\WatchLoginLog;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\Facades\MQTT;

class MQTTService
{
    /**
     * USE IN REI
     */
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

    public static function sendComplete($status_record_id)
    {
        $sr = StatusRecord::with('attending')->find($status_record_id);
        $content["status_record_id"] = $sr->id;
        $content["machine_code"] =  $sr->machine_code;
        $content["segment_code"] =  $sr->segment_code;
        $content["message"] = $sr->machine_code . " completed by " . $sr->employee_name;

        try {
            MQTT::publish(TOPIC_COMPLETE, json_encode($content));
            MQTT::disconnect();
        } catch (Exception $e) {
            Log::error('sendComplete() ' . $e);
        }
    }

    /*
    * USE IN WATCH
    * Send to watch and watch will trigger POST: /watch/login
    */
    public static function sendLogin(WatchLoginLog $log, $mode)
    {
        $content['employee_code'] = $log->user->username;
        $content['login_mode'] = $mode; //WEB OR BADGE;
        $content['timeout_second'] = (config('setting.watch_login_timeout') - 2); //Login Window Appear for how many seconds
        try {
            MQTT::publish(TOPIC_LOGIN . "/" . $log->watch->code, json_encode($content));
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
