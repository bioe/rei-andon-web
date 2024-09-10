<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\WatchLoginRequest;
use App\Models\Watch;
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
            'watch_login_id' => $request->session()->get('watch_login_id') //Login success get from flash session
        ]);
    }

    public function postLogin(WatchLoginRequest $request)
    {
        $request->authenticate();

        //Validation success
        $watch = Watch::where('code', $request->watch_code)->first();
        if ($watch) {
            $watch->login_user_id = $request->user->id; //Coming from WatchLoginRequest
            $watch->login_at = null;
            $watch->save();

            //Send MQTT
            MQTTService::sendLogin($watch, WATCH_LOGIN_WEB);

            return Redirect::route('watch_login')->with('watch_login_id', $watch->id);
        }
    }

    public function getIsLogin(Watch $watch)
    {
        if ($watch->login_at != null) return response()->json(['success' => true, 'message' => 'Successfully login to ' . $watch->code]);
        return response()->json(['success' => false]);
    }
}
