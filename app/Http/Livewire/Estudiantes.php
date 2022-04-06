<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Nivel;
use App\Models\Total_puntos;

class Estudiantes extends Component
{
    public $gradoseleccionado;
    
    public function render()
    {
        $grados = Nivel::get();
        $estudiantes = null;
        $puntajes = '[]';

        if($this->gradoseleccionado!=null){
            $estudiantes = User::where(['nivel_id'=>$this->gradoseleccionado])->orderBy('apellido','asc')->get();
            $puntajes = Total_puntos::where(['grado_id'=>$this->gradoseleccionado])->get()->toArray();
        }
        return view('livewire.estudiantes',[
            'grados'=>$grados,
            'estudiantes'=>$estudiantes,
            'puntajes'=>$puntajes,
        ]);
    }
}
