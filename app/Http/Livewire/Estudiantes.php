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
    public $estudiante;

    protected $queryString  = ['gradoseleccionado','estudiante'];
    protected $listeners  = ['change','drop'];
    
    public function render()
    {
        $grados = Nivel::get();
        $estudiantes = null;
        $puntajes = '[]';
        $dias = [];

        $fechaLunes =  date('Ymd',strtotime('this week'));
        $fechaMartes =  date('Ymd',strtotime('this week +1 days'));
        $fechaMiercoles =  date('Ymd',strtotime('this week +2 days'));
        $fechaJueves =  date('Ymd',strtotime('this week +3 days'));
        $fechaViernes =  date('Ymd',strtotime('this week +4 days'));

        

        $dias[$fechaLunes] = [];
        $dias[$fechaMartes] = [];
        $dias[$fechaMiercoles] = [];
        $dias[$fechaJueves] = [];
        $dias[$fechaViernes] = [];

        $textdias = [];
        $textdias[$fechaLunes] = 'Lunes';
        $textdias[$fechaMartes] = 'Martes';
        $textdias[$fechaMiercoles] = 'Miercoles';
        $textdias[$fechaJueves] = 'Jueves';
        $textdias[$fechaViernes] = 'Viernes';

        $estudiantes_data = [];

        if($this->gradoseleccionado!=null){
            
            $from = date('Y/m/d',strtotime('this week')); //de lunes
            $to = date('Y/m/d',strtotime('this week +4 days'));//a viernes
            //$from = date('d/m/Y',strtotime('03/04/2022'));
            //$to = date('d/m/Y',strtotime('07/04/2022'));

            $estudiantes = null;

            if($this->estudiante!=null){
                $estudiantes = User::where([
                    ['name','like','%' . $this->estudiante . '%']
                    ])->orderBy('apellido','asc')->get();
            }else{
                $estudiantes = User::where(['nivel_id'=>$this->gradoseleccionado])->orderBy('apellido','asc')->get();
            }

            

            
            //$puntajes = Total_puntos::where(['grado_id'=>$this->gradoseleccionado])->whereBetween('updated_at',[$from,$to])->get();
            $practicas = Practica::whereHas('grados', function($query){
                $query->where(['nivel_id'=>$this->gradoseleccionado]);
            })->get();

            $arrPracticasPermitidas = [];
            if($practicas->count()>0){
                foreach($practicas as $practica){
                    $arrPracticasPermitidas[] = $practica->id;
                }
            }
            $puntajes = Total_puntos::where(['grado_id'=>$this->gradoseleccionado])->whereIn('tarea_id', $arrPracticasPermitidas)->get();

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

                            $theday = date('Ymd',strtotime('this week'));

                            if($dia >= 1){
                                $extradia = $dia;
                                $theday = date('Ymd',strtotime('this week +' . $extradia . ' days'));
                            }
                            $dias[$theday][$practica->id] = $practica->titulo;
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
                            //$dayoftheweek = date('w',strtotime($notav['fecha'])) - 1;
                            //dayofweek si es miercoles marcara 1
                            //
                            $fechaentera = date('Ymd',strtotime($notav['fecha']));
                            $nota = $notav['nota'];
                            //$estudiantes_data[$estudiante_id][$dayoftheweek][$puntaje->tarea_id] = $nota;
                            $estudiantes_data[$estudiante_id][$fechaentera][$puntaje->tarea_id] = $nota;
                        }
                    }
                }
            }
            /*dd($estudiantes_data);
            array:11 [▼
  198 => []
  88 => []
  119 => []
  90 => []
  143 => []
  186 => array:1 [▼
    20220412 => array:1 [▶]
  ]
  43 => []
  56 => array:3 [▼
    20220406 => array:2 [▶]
    20220412 => array:3 [▼
      7 => 10
      6 => 20
      10 => 20
    ]
    20220408 => array:1 [▶]
  ]
  41 => array:4 [▼
    20220405 => array:1 [▶]
    20220407 => array:1 [▶]
    20220409 => array:1 [▶]
    20220411 => array:2 [▶]
  ]
  65 => array:2 [▼
    20220406 => array:2 [▶]
    20220412 => array:2 [▶]
  ]
  35 => []
]*/
            
            
        }
        return view('livewire.estudiantes',[
            'grados'=>$grados,
            'estudiantes'=>$estudiantes,
            'puntajes'=>$puntajes,
            'dias'=>$dias,
            'textdias' => $textdias,
            'estudiantes_data'=>$estudiantes_data
        ]);
    }
    public function change($id,$grado){
        $user = User::find($id);
        if($user!=null){
            $user->update([
                'nivel_id'=>$grado
            ]);
        }
    }
    public function drop($id){
        $user = User::find($id);
        if($user!=null){
            
            $user->delete();
        }
    }
}
