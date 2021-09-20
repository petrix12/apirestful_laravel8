<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, ApiTrait;

    // Relación polimórfica entre **images** y otros modelos
    // El nombre de la función debe coincidir con el de su migración
    public function imageable(){
        return $this->morphTo();
    }
}
