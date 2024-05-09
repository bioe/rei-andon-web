<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Segment;
use App\Models\StatusRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecordReportController extends Controller
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

        return Inertia::render('Reports/RecordReport/Index', [
            'header' => StatusRecord::header(),
            'filters' => $filters,
            'list' => $list,
            'segments' => $segments
        ]);
    }

    public function destroy(StatusRecord $statusrecord)
    {
        $statusrecord->delete();
        return Redirect::route('reports.records.index')->with('message', 'Record deleted successfully');
    }
}
