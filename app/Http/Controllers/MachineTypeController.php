<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MachineTypeUpdateReqeust;
use App\Models\MachineType;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MachineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'machinetype', [
            'keyword' => ''
        ]);

        $list = MachineType::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('code', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('MachineType/Index', [
            'header' => MachineType::header(),
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
    public function store(MachineTypeUpdateReqeust $request)
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
            $data = new MachineType;
        }else{
            $data = MachineType::find($id);
        }

        return Inertia::render('MachineType/EditPartial', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MachineTypeUpdateReqeust $request, string $id = null)
    {
        $data = $request->validated();
        if(null == $id){
            $data = MachineType::create($data);
            return Redirect::route('machinetypes.edit', $data->id)->with('message', 'Machine type created successfully');
        }else{
            MachineType::find($id)->update($data);
            return Redirect::route('machinetypes.edit', $id)->with('message', 'Machine type updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        MachineType::find($id)->delete();
        return Redirect::route('machinetypes.index')->with('message', 'Machine type deleted successfully');
    }
}
