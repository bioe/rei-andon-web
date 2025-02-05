<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\UserImportRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Imports\UsersImport;
use App\Models\Group;
use App\Models\User;
use App\Models\Watch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Build Filter
        $filters = $this->filterSessions($request, 'user', [
            'keyword' => ''
        ]);

        $list = User::query()->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->orWhere('name', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('email', 'like', '%' . $filters['keyword'] . '%');
            $q->orWhere('username', 'like', '%' . $filters['keyword'] . '%');
        })->filterSort($filters)->paginate(config('table.page_limit'));

        return Inertia::render('User/Index', [
            'header' => User::header(),
            'filters' => $filters,
            'list' => $list,
            'useUsername' => env(LOGIN_USERNAME, false)
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
    public function store(UserUpdateRequest $request)
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
            $data = new User;
        } else {
            $data = User::with('groups')->find($id)->append('group_ids');
        }

        $menu_list = config('menus.items');
        $group_options = treeselect_options(Group::where('active', true)->get(), 'id', 'code');
        $watch_options = treeselect_options(Watch::where('active', true)->get(), 'id', 'code');

        return Inertia::render('User/Edit', [
            'data' => $data,
            'useUsername' => env(LOGIN_USERNAME, false),
            'menu_list' => $menu_list,
            'group_options' => $group_options,
            'shift_options' => User::shift_options(),
            'user_type_options' => User::user_type_options(),
            'watch_options' => $watch_options
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id = null)
    {
        $data = $request->validated();
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (!isset($data['watch_id'])) {
            $data['watch_id'] = null;
        }

        if (null == $id) {
            $data = User::create($data);
            return Redirect::route('users.edit', $data->id)->with('message', 'User created successfully');
        } else {
            User::find($id)->update($data);
            return Redirect::route('users.edit', $id)->with('message', 'User updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::route('users.index')->with('message', 'User deleted successfully');
    }

    /**
     * Save Menu
     */
    public function patchMenu(Request $request, $id)
    {
        $data = User::find($id);
        $data->menus = $request->menus;
        $data->save();
        return Redirect::route('users.edit', $data->id)->with('message', 'Menu Permission Updated');
    }

    /**
     * Save Group
     */

    public function patchGroup(Request $request, $id)
    {
        $data = User::find($id);
        $data->groups()->detach();
        $data->groups()->attach($request->groups);
        return Redirect::route('users.edit', $data->id)->with('message', 'Group Updated');
    }

    public function getExport()
    {
        return Excel::download(new UsersExport, 'andon_users.xlsx');
    }

    public function postImport(UserImportRequest $request)
    {
        $file = $request->file('file');

        try {
            $import = (new UsersImport)->import($request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $error_messages = [];
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.

                foreach ($failure->errors() as $error) {
                    $error_messages[] = "Row " . $failure->row() . " - [" . $failure->values()[$failure->attribute()] . "] " . $error;
                }
            }
            return Redirect::back()->withErrors($error_messages);
        }

        return Redirect::route('users.index')->with('message', 'Upload successfully');
    }
}
