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
        $msg = session('interval_login_message', '');
        //Clear
        session(['interval_login_message' => '']);

        return Inertia::render('Auth/WatchLogin', [
            'timeout_sec' => config('setting.watch_login_timeout', 1) * 1000,
            'watch_login_log_id' => $request->session()->get('watch_login_log_id'), //Login success get from flash session
            'login_message' => $msg //Display message from getIsLogin()
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
        return Redirect::route('watch_login.main')->with('watch_login_log_id', $log->id);
    }

    public function getIsLogin(WatchLoginLog $watch_login_log)
    {
        if ($watch_login_log->success == true) {
            $msg = 'Successfully login to ' . $watch_login_log->watch->code;
            session(['interval_login_message' => $msg]);

            return response()->json(['success' => true]);
        } else if ($watch_login_log->cancel == true) {
            $msg = 'Login cancel for ' . $watch_login_log->watch->code;

            session(['interval_login_message' => $msg]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function getAvailableWatch(Request $request)
    {
        return response()->json($this->availableWatchOptions($request->keyword));
    }

    private function availableWatchOptions($keyword = null)
    {
        $watch = Watch::query()
            ->whereNull('login_user_id')
            ->when($keyword != null && !empty($keyword), function ($q) use ($keyword) {
                $q->where('code', 'like', '%' . $keyword . '%');
            })->get();
        $list = treeselect_options($watch, 'code', 'code');
        return $list;
    }
}
