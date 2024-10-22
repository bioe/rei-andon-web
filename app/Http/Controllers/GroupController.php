<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\MachineType;
use App\Models\Segment;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'group', [
            'keyword' => ''
        ]);

        $list = Group::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('description', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        //Not using Attribute is to prevent each row query Status Model, here only query once and combine the data
        $all_status = Status::all()->keyBy('id');
        $list->each(function ($data) use ($all_status) {
            $data->status_label = "";
            if ($data->status_list != null) {
                for ($i = 0; $i < count($data->status_list); $i++) {
                    $status_id = $data->status_list[$i];
                    if (isset($all_status[$status_id])) {
                        $data->status_label .= $all_status[$status_id]->code;
                        //Add comma if not last
                        if (($i + 1) !=  count($data->status_list)) {
                            $data->status_label .= ", ";
                        }
                    }
                }
            }
        });

        return Inertia::render('Group/Index', [
            'header' => Group::header(),
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
    public function store(UpdateGroupRequest $request)
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
        if (null == $id) {
            $data = new Group;
        } else {
            $data = Group::find($id);
        }

        $mt = MachineType::all();
        $type_of_machines = treeselect_options($mt, 'code', 'name');
        $segments = Segment::all();
        $status = Status::all();
        $type_of_statuses = treeselect_options($status, 'id', 'name');
        return Inertia::render('Group/Edit', [
            'data' => $data,
            'type_of_machines' => $type_of_machines,
            'type_of_statuses' => $type_of_statuses,
            'segments' => $segments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, string $id = null)
    {
        $data = $request->validated();

        $data['last_edit_user_id'] = Auth::user()->id;
        if (null == $id) {
            $data = Group::create($data);
            return Redirect::route('groups.edit', $data->id)->with('message', 'Group created successfully');
        } else {
            Group::find($id)->update($data);
            return Redirect::route('groups.edit', $id)->with('message', 'Group updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return Redirect::route('statuses.index')->with('message', 'Group deleted successfully');
    }
}
