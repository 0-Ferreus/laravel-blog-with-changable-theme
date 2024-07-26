<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    public function defaultTheme(){
        return $this->belongsTo(DefaultTheme::class);
    }
}
