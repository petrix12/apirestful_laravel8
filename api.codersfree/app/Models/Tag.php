<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Relación n:m entre **tags** y **posts**
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
