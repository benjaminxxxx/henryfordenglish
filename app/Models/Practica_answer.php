<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practica_answer extends Model
{
    use HasFactory;
    protected $fillable = ['practica_id','practica_question_id','answer','alumno','points','grado_id','student_id'];
}
