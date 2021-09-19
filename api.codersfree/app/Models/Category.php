<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Relación 1:n entre **categories** y **posts**
    public function posts(){
        return $this->hasMany(Post::class);
    }
}