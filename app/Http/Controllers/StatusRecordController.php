<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRecordUpdateRequest;
use App\Models\Machine;
use App\Models\Segment;
use App\Models\Status;
use App\Models\StatusRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StatusRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'report.record', [
            'keyword' => '',
            'segment_code' => null
        ]);

        $list = StatusRecord::query()->with('responses')->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('machine_code', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('employee_code', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('segment_code', 'like', '%' . $filters['keyword'] . '%');
        })->when($filters['segment_code'] != null, function ($q) use ($filters) {
            $q->where('segment_code', $filters['segment_code']);
        })->filterSort($filters)->orderBy('created_at', 'desc')->paginate(config('table.report_limit'));
        $list->each(function ($data) {
            $data->last_responsed_at = "";
            $data->last_responsed_employee = "";
            if ($data->responses->count() > 0) {
                $data->last_responsed_at = $data->responses[0]->created_at;
                $data->last_responsed_employee = $data->responses[0]->employee_code;
            }
        });

        //Filter options
        $segments = Segment::where('active', true)->get();

        return Inertia::render('StatusRecord/Index', [
            'header' => StatusRecord::header(),
            'filters' => $filters,
            'list' => $list,
            'segments' => $segments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $this->edit($request, null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRecordUpdateRequest $request)
    {
        return $this->update($request, null);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Request $request, string $id = null)
    {
        if (null == $id) {
            $data = new StatusRecord;
        } else {
            $data = StatusRecord::find($id);
        }

        if ($request->has('machine_code')) {
            $data->machine_code = $request->input('machine_code');
        }

        $machines = Machine::where("active", true)->get();
        $statuses = Status::where("active", true)->get();

        return Inertia::render('StatusRecord/Edit', [
            'data' => $data,
            'machines' => $machines,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusRecordUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        $machine = Machine::with('segment')->with('machine_type')->where('code', $data['machine_code'])->first();
        $data['segment_code'] = $machine->segment->code;
        $data['machine_type'] = $machine->machine_type->code;
        $data['employee_id'] = Auth::user()->id;
        $data['employee_code'] = Auth::user()->username;
        $data['employee_name'] = Auth::user()->name;
        $data['origin'] = WEB;


        if (null == $id) {
            $data = StatusRecord::create($data);
            $this->sendMqtt();
            return Redirect::route('dashboard')->with('message', 'Record created successfully');
        } else {
            StatusRecord::find($id)->update($data);
            $this->sendMqtt();
            return Redirect::route('statusrecords.edit', $id)->with('message', 'Record updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusRecord $statusrecord)
    {
        $statusrecord->delete();
        return Redirect::route('statusrecords.index')->with('message', 'Record deleted successfully');
    }

    public function sendMqtt() {}
}
