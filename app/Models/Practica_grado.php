<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practica_grado extends Model
{
    use HasFactory;

    public function practicas(){
        return $this->hasMany(Practica::class,'id');
    }

}
