<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Article;
use App\Models\Category;
use App\Models\DefaultTheme;
use App\Models\PostTheme;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index(){
        $selected = DefaultTheme::find(1);
        $app = App::find($selected->app)->name;
        $script = App::find($selected->app)->post_theme;
        $categories = Category::all();

        $latest = Article::latest()->first();
        $articles = Article::where('id', '!=', $latest->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(2);
        return view('front.index',compact(['latest','articles','categories','app','script']));
    }

    public function show($id){
        $selected = DefaultTheme::find(1);
        $app = App::find($selected->app)->name;
        $script = PostTheme::find($selected->post_theme)->name;
        $categories = Category::all();
        $article = Article::FindOrFail($id);
        $category = Category::find($article->category_id);
        $articles = Article::where('id', '!=', $article->id)
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
        return view('front.post',compact(['article','category','categories','app','articles','script']));
    }

    public function dashboard(){
        $selected = DefaultTheme::find(1);
        $app = App::find($selected->app)->name;
        $script = App::find($selected->app)->post_theme;
        return view('dashboard',compact(['selected','app','script']));
    }
}
