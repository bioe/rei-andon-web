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
        $machines = Machine::with('last_status_record.status')->with('last_status_record.attended')->where('active', true)->get();

        return Inertia::render('Dashboard', [
            'watches' => $watches,
            'machines' => $machines
        ]);
    }
}
