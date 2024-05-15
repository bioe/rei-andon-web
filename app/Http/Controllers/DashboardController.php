<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Watch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $watches = Watch::with('login_user')->where('active', true)->get();

        return Inertia::render('Dashboard', [
            'watches' => $watches,
            'group_machines' => $this->refreshMachine(),
            'refresh_second' => DASHBOARD_REFRESH_SECOND
        ]);
    }

    public function refresh()
    {
        $data['group_machines'] = $this->refreshMachine();
        return response()->json($data);
    }

    public function refreshMachine()
    {
        $machines = Machine::with('machine_type')->with('last_status_record.status')->with('last_status_record.attended')->where('active', true)->get();

        $group_machines = [];
        foreach ($machines as $m) {
            $group_machines[$m->machine_type->code][] = $m;
        }
        return $group_machines;
    }
}
