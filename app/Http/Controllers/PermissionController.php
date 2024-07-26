<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;


class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('permissions.index', compact(['permissions']));
    }

    public function create()
    {
        return view('permissions.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permissions.create')
                ->withInput()
                ->withErrors($validator);
        }

        Permission::create(['name' => $request->name]);
        // Redirect to the permissions list with a success message
        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }


    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact(['permission']));
    }


    public function update(Request $request,$id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|min:3',
        ]);

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        Permission::find($id)->delete();
    }

    public function data()
    {
        $permissions = Permission::all();
        return DataTables::of($permissions)
            ->addColumn('action', function ($row) {
                $action = '<a href="' . route('permissions.edit', $row->id) . '"><button class="btn btn-primary mr-4 edit">Edit</button></a> &nbsp';
                $action .= '<button data-id="'. $row->id .'" class="btn btn-danger delete">Delete</button>';
                return $action;
            })
            ->rawColumns(['name','created_at','action'])
            ->make(true);
    }
}
