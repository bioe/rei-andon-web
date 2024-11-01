<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Watch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WatchDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('WatchDashboard/Dashboard', [
            'watches' => $this->refreshWatch(),
            'refresh_second' => DASHBOARD_REFRESH_SECOND
        ]);
    }

    public function refresh()
    {
        $data['watches'] = $this->refreshWatch();
        return response()->json($data);
    }

    private function refreshWatch()
    {
        $watches = Watch::with('login_user.active_response_record')
            ->where('active', true)
            ->get()
            ->map(function ($watch) {
                if ($watch->login_user != null && $watch->login_user->active_response_record != null) {
                    $watch->colour_class = 'bg-danger';
                } else if ($watch->login_user != null) {
                    $watch->colour_class = 'bg-success';
                } else {
                    $watch->colour_class = 'bg-warning';
                }
                return $watch;
            });
        return $watches;
    }
}
