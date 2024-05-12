<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegmentUpdateRequest;
use App\Models\Segment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class SegmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'segment', [
            'keyword' => ''
        ]);

        $list = Segment::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('code', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('Segment/Index', [
            'header' => Segment::header(),
            'filters' => $filters,
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SegmentUpdateRequest $request)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        if(null == $id){
            $data = new Segment;
        }else{
            $data = Segment::find($id);
        }

        return Inertia::render('Segment/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SegmentUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if(null == $id){
            $data = Segment::create($data);
            return Redirect::route('segments.edit', $data->id)->with('message', 'Segment created successfully');
        }else{
            Segment::find($id)->update($data);
            return Redirect::route('segments.edit', $id)->with('message', 'Segment updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Segment::find($id)->delete();
        return Redirect::route('segments.index')->with('message', 'Segment deleted successfully');
    }
}
