<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,ApiTrait;

    const BORRADOR = 1;
    const PUBLICADO = 2;

    // Relación 1:n entre **users** y **posts** (inversa)
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relación 1:n entre **categories** y **posts** (inversa)
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Relación n:m entre **posts** y **tags**
    public function tags(){
        return $this->belongsToMany(Tag::class);
    } 
    
    // Relación 1:n polimorfica 1:n entre **posts** y **images**
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
}
