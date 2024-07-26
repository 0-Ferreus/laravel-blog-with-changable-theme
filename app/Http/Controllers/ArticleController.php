<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('articles.index', compact(['articles']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();

        return view('articles.create',compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'nullable',
        ]);

        $data = $request->only(['title', 'body']);
        $data['category_id'] = $request->category;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        $article = Article::create($data);
        DB::table('article_category')->insert([
            'article_id' => $article->id,
            'category_id' => $request->category
        ]);
        
        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
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
        $categories = Category::all();
        $article = Article::find($id);
        return view('articles.edit', compact(['article','categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable',
        ]);

        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $article->category_id = $request->input('category');
        $filename = public_path('images') . '/' . $article->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image) {
                if ($filename) {
                    File::delete($filename);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $article->image = $imageName;
        }
        

        $article->save();

        return response()->json(['status' => 'success']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $article = Article::findOrFail($id);
        $filename = public_path('images') . '/' . $article->image;

        // Delete the associated image from storage
        if ($article->image) {
            File::delete($filename);
        }

        // Delete the article
        $article->delete();

        return response()->json(['status' => 'success']);
    }

    public function data()
    {
        $articles = Article::with('category')->get();
        
        return DataTables::of($articles)
            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->name : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="' . route('articles.edit', $row->id) . '"><button class="btn btn-primary mr-4 edit">Edit</button></a> &nbsp';
                $action .= '<button data-id="'. $row->id .'" class="btn btn-danger delete">Delete</button>';
                return $action;
            })
            ->rawColumns(['title','category','created_at','action'])
            ->make(true);
    }
    
}
