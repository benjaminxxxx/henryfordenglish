<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practica extends Model
{
    use HasFactory;
    protected $fillable = ['titulo','link','estado','user_id','maximo','dias'];
    //public $timestamps = false;

    public function grados(){
        return $this->belongsToMany(Nivel::class,'practica_grados');
    }
}
