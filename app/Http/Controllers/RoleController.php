<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;


class RoleController extends Controller
{
    //
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->paginate(10);
        return view('roles.index', compact(['roles']));
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('roles.create', compact(['permissions']));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('roles.create')
                ->withInput()
                ->withErrors($validator);   
        }

        $role = Role::create(['name' => $request->name]);
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $perm) {
                $role->givePermissionTo($perm);
            }
        }
        // Redirect to the roles list with a success message
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }


    public function edit($id)
    {

        $permissions = Permission::orderBy('name', 'asc')->get();
        $role = Role::find($id);
        $hasPermissions = $role->permissions->pluck('name');
        return view('roles.edit', compact(['role', 'permissions', 'hasPermissions']));
    }


    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|min:3',
        ]);
        $role->name = $request->name;
        if (!empty($request->permissions)) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }


    public function destroy($id)
    {
        Role::find($id)->delete();
    }

    public function data()
    {
        $roles = Role::with('permissions')->get();
        return DataTables::of($roles)
            ->addColumn('permissions', function ($row) {
                // Assuming permissions have a 'name' attribute
                return $row->permissions->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="' . route('roles.edit', $row->id) . '"><button class="btn btn-primary mr-4 edit">Edit</button></a> &nbsp';
                $action .= '<button data-id="' . $row->id . '" class="btn btn-danger delete">Delete</button>';
                return $action;
            })
            ->rawColumns(['name', 'permissions', 'action'])
            ->make(true);
    }
}
