<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        $roles = Role::all();
        $hasRole = $user->roles->pluck('name');
        return view('users.edit', compact(['user','roles', 'hasRole']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email,' . $user->id . '|email',
        ]);
        $user->name = $request->name;
        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);
        } else {
            $user->syncRoles([]);
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        User::find($id)->delete();

    }

    public function data()
{
    $users = User::with('roles')->get();
    return Datatables::of($users)
        ->addColumn('roles', function ($row) {
            return $row->roles->pluck('name')->implode(', ');
        })
        ->addColumn('action', function ($row) {
            $action = '<a href="' . route('users.edit', $row->id) . '"><button class="btn btn-primary mr-4 edit">Edit</button></a> &nbsp';

            $action .= '<button data-id="'. $row->id .'" class="btn btn-danger delete">Delete</button>';
            return $action;
        })
        ->rawColumns(['roles', 'action'])
        ->make(true);
}
}
