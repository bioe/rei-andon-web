<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Watch;
use Carbon\Carbon;
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

        return Inertia::render('Dashboard/Dashboard', [
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

    private function refreshMachine()
    {
        $time = Carbon::now()->subMinute(LATEST_RECORD_VIEW_MINUTE);

        $machines = Machine::with('machine_type')
            ->with('last_status_record.status')->with('last_status_record.attended', function ($query) use ($time) {
                $query->where('created_at', '>=', $time);
            })
            ->where('active', true)->get();

        $group_machines = [];

        foreach ($machines as $m) {
            if ($m->last_status_record != null && $m->last_status_record->created_at->lt($time)) {
                $m->last_status_record = null;
                $m->setRelation('last_status_record', null);
            } else if ($m->last_status_record != null) {
                $m->bg_colour = "bg-success";
                //Show Status
                $m->current_status_code = null;
                //Show Person
                $m->current_employee = null;
                if ($m->last_status_record->attended == null) {
                    $m->bg_colour = "bg-danger";
                    $m->current_status_code = $m->last_status_record->status->code;
                } else if ($m->last_status_record->attended != null) {
                    $m->bg_colour = "bg-warning";
                    $m->current_employee = $m->last_status_record->attended->employee_name . ' - ' . $m->last_status_record->attended->response_option;
                }
            }
            $group_machines[$m->machine_type->code][] = $m;
        }
        return $group_machines;
    }
}
