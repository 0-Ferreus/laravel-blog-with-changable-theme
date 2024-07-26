<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'app',
        'post_theme',
    ];

    public function app(){
        return $this->hasOne(App::class);
    }

    public function postTheme(){
        return $this->hasOne(PostTheme::class);
    }
}
