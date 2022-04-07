<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Nivel;
use App\Models\Total_puntos;
use App\Models\Practica;

class Estudiantes extends Component
{
    public $gradoseleccionado;

    protected $queryString  = ['gradoseleccionado'];
    
    public function render()
    {
        $grados = Nivel::get();
        $estudiantes = null;
        $puntajes = '[]';
        $dias = [
            0 => [], //lunes
            1 => [],
            2 => [],
            3 => [],
            4 => []
        ];

        $estudiantes_data = [];

        if($this->gradoseleccionado!=null){
            
            $from = date('Y/m/d',strtotime('this week'));
            $to = date('Y/m/d',strtotime('this week +4 days'));
            //$from = date('d/m/Y',strtotime('03/04/2022'));
            //$to = date('d/m/Y',strtotime('07/04/2022'));

            $estudiantes = User::where(['nivel_id'=>$this->gradoseleccionado])->orderBy('apellido','asc')->get();
            $puntajes = Total_puntos::where(['grado_id'=>$this->gradoseleccionado])->whereBetween('created_at',[$from,$to])->get();
            $practicas = Practica::whereHas('grados', function($query){
                $query->where(['nivel_id'=>$this->gradoseleccionado]);
            })->get();

            

            if($estudiantes->count()>0){
                foreach($estudiantes as $estudiante){
                    $estudiantes_data[$estudiante->id] = [];
                }
            }

            if($practicas->count()>0){
                foreach($practicas as $practica){
                    $dias2 = json_decode($practica->dias,true);
                    if (is_array($dias2) && count($dias2)>0) {
                        foreach ($dias2 as $dia) {
                            $dias[$dia][$practica->id] = $practica->titulo;
                        }
                    }
                }
            }

            

            if($puntajes->count()>0){
                foreach($puntajes as $puntaje){
                    $estudiante_id = $puntaje->user_id;
                    
                    $notas = json_decode($puntaje->puntos,true);
                    if(is_array($notas) && count($notas)>0){
                        foreach ($notas as $notav) {
                            $dayoftheweek = date('w',strtotime($notav['fecha'])) - 1;
                            $nota = $notav['nota'];
                            $estudiantes_data[$estudiante_id][$dayoftheweek][$puntaje->tarea_id] = $nota;
                        }
                    }
                }
            }

            
        }
        return view('livewire.estudiantes',[
            'grados'=>$grados,
            'estudiantes'=>$estudiantes,
            'puntajes'=>$puntajes,
            'dias'=>$dias,
            'estudiantes_data'=>$estudiantes_data
        ]);
    }
}
