<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\MachineType;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Requests\MachineUpdateRequest;
use App\Models\Segment;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'machine', [
            'keyword' => ''
        ]);

        $list = Machine::query()->with('machine_type')->with('segment')->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('code', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('Machine/Index', [
            'header' => Machine::header(),
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
    public function store(MachineUpdateRequest $request)
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
        $machineTypes = MachineType::all();
        $segments = Segment::all();

        if (null == $id) {
            $data = new Machine;
        } else {
            $data = Machine::find($id);
        }

        return Inertia::render('Machine/Edit', [
            'data' => $data,
            'machineTypes' => $machineTypes,
            'segments' => $segments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MachineUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if (null == $id) {
            $data = Machine::create($data);
            return Redirect::route('machines.edit', $data->id)->with('message', 'Machine created successfully');
        } else {
            Machine::find($id)->update($data);
            return Redirect::route('machines.edit', $id)->with('message', 'Machine updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Machine::find($id)->delete();
        return Redirect::route('machines.index')->with('message', 'Machine deleted successfully');
    }
}
