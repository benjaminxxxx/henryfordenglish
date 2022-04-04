<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practica_question extends Model
{
    use HasFactory;
    protected $fillable = ['practica_id','question','options','answer','points','time','question_imagen','estado'];
}
