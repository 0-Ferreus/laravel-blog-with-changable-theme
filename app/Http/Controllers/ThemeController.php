<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\DefaultTheme;
use App\Models\PostTheme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    //
    public function index(){
        $theme = DefaultTheme::find(1)->first();
        $post_theme = PostTheme::all();
        $app_theme = App::All();
        return view('theme.index',compact(['theme','post_theme','app_theme']));
    }

    public function update(Request $request){
        $theme = DefaultTheme::find(1);

    if ($theme) {
        $theme->update([
            'app' => $request->app_theme,
            'post_theme' => $request->post_theme
        ]);

        return redirect()->route('theme.index')->withSuccess('Theme Updated Successfully.');
    }

    return redirect()->route('theme.index')->withErrors('Theme not found.');
    }
}
