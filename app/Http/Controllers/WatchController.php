<?php

namespace App\Http\Controllers;

use App\Http\Requests\WatchUpdateRequest;
use App\Models\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class WatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'watch', [
            'keyword' => ''
        ]);

        $list = Watch::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('email', 'like', '%' . $filters['keyword'] . '%');
        })->with('login_user')->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('Watch/Index', [
            'header' => Watch::header(),
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
    public function store(WatchUpdateRequest $request)
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
            $data = new Watch;
        } else {
            $data = Watch::find($id);
        }

        return Inertia::render('Watch/Edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WatchUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if (null == $id) {
            $data = Watch::create($data);
            return Redirect::route('watches.edit', $data->id)->with('message', 'Watch created successfully');
        } else {
            Watch::find($id)->update($data);
            return Redirect::route('watches.edit', $id)->with('message', 'Watch updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Watch $watch)
    {
        $watch->delete();
        return Redirect::route('watches.index')->with('message', 'Watch deleted successfully');
    }

    /**
     * Clear Login Data
     */
    public function postLogout(Watch $watch)
    {
        $watch->login_user_id = null;
        $watch->login_at = null;
        $watch->save();
        return Redirect::route('watches.index')->with('message', 'Watch ' . $watch->code . ' logout successfully');
    }
}
