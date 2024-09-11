<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\WatchLoginRequest;
use App\Models\Watch;
use App\Models\WatchLoginLog;
use App\Services\MQTTService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class WatchLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Auth/WatchLogin', [
            'timeout_sec' => config('setting.watch_login_timeout', 1) * 1000,
            'watch_login_log_id' => $request->session()->get('watch_login_log_id') //Login success get from flash session
        ]);
    }

    public function postLogin(WatchLoginRequest $request)
    {
        $request->authenticate();
        //Validation success
        //Coming from WatchLoginRequest
        $watch = $request->watch;
        $user = $request->user;

        //Delete no login log
        $log = WatchLoginLog::ofPending()->where('watch_id', $watch->id)->orderBy('created_at', 'desc')->first();
        if ($log) $log->delete();

        //Create new 
        $log = WatchLoginLog::create([
            'watch_id' => $watch->id,
            'user_id' => $user->id,
            'mode' => WATCH_LOGIN_WEB
        ]);

        //Send MQTT
        MQTTService::sendLogin($log, WATCH_LOGIN_WEB);
        return Redirect::route('watch_login')->with('watch_login_log_id', $log->id);
    }

    public function getIsLogin(WatchLoginLog $watch_login_log)
    {
        if ($watch_login_log->success == true) {
            return response()->json(['success' => true, 'message' => 'Successfully login to ' . $watch_login_log->watch->code]);
        } else if ($watch_login_log->cancel == true) {
            return response()->json(['success' => true, 'message' => 'Login cancel by ' . $watch_login_log->watch->code]);
        }
        return response()->json(['success' => false]);
    }
}
