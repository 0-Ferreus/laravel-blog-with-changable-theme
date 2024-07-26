<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);
        if ($validator->fails()) {
            return redirect()->route('roles.create')
                ->withInput()
                ->withErrors($validator);
        }

        Category::create(['name'=>$request->name]);
        
        return redirect()->route('categories.index')
        ->with('success', 'Category created successfully.');
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
        $category = Category::find($id);
        return view('categories.edit', compact(['category']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|min:3',
        ]);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Category::find($id)->delete();
    }

    public function data()
    {
        $categories = Category::all();
        return DataTables::of($categories)
            ->addColumn('action', function ($row) {
                $action = '<a href="' . route('categories.edit', $row->id) . '"><button class="btn btn-primary mr-4 edit">Edit</button></a> &nbsp';
                $action .= '<button data-id="' . $row->id . '" class="btn btn-danger delete">Delete</button>';
                return $action;
            })
            ->rawColumns(['name', 'action'])
            ->make(true);
    }
}
