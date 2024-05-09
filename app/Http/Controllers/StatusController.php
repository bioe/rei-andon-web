<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusUpdateRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'status', [
            'keyword' => ''
        ]);

        $list = Status::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('email', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('Status/Index', [
            'header' => Status::header(),
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
    public function store(StatusUpdateRequest $request)
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

    public function edit(string $id = null)
    {
        if (null == $id) {
            $data = new Status;
        } else {
            $data = Status::find($id);
        }

        return Inertia::render('Status/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if (null == $id) {
            $data = Status::create($data);
            return Redirect::route('statuses.edit', $data->id)->with('message', 'Status created successfully');
        } else {
            Status::find($id)->update($data);
            return Redirect::route('statuses.edit', $id)->with('message', 'Status updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route('statuses.index')->with('message', 'Status deleted successfully');
    }
}
