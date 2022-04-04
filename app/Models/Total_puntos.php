<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total_puntos extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','tarea_id','puntos','grado_id','alumno'];

}
