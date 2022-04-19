<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Nivel;
use App\Models\Practica;
use App\Models\Practica_question;
use App\Models\Practica_answer;
use App\Models\Total_puntos;
use App\Models\Practica_grado;


class PracticaController extends Controller{

    public function index(Request $request,$id=false){

        if(Auth::user()->type==null)
        {
            //estudiantes
            $temp = Practica::whereHas('grados', function($query){
                $query->where(['nivel_id'=>Auth::user()->nivel_id]);
            })->get();

            $semana = [
                [],[],[],[],[]
            ];

            if($temp->count()>0){
                
                foreach ($temp as $practica) {
                    $dias = json_decode($practica->dias,true);
                    
                    if(is_array($dias) && count($dias)>0){
                        foreach($dias as $d){
                            $fechapractica = date('Y-m-d',strtotime('this week' . '+' . $d . ' days'));
                            \DB::enableQueryLog();
                            $fecha_practica = Total_puntos::where(['user_id'=>Auth::user()->id,'tarea_id'=>$practica->id])->whereDate('created_at',$fechapractica)->first();
                            
                            $estaresuelto = false;
                            dd(\DB::getQueryLog());
                            if($fecha_practica!=null){
                               
                                $estaresuelto = true;
                            }

                            $semana[$d][] = [
                                'estaresuelto' => $estaresuelto,
                                'practica' => $practica
                            ];
                        }
                    }
                }
            }
            return view('calendar',[
                'semanas'=>$semana
            ]);
        }
        $selected_id = null;
        $practica_titulo = '';
        $practica_grados = [];
        $ingrados = [];
        $dias = '';
        
        if($id!=false){
            
            //editar
            $selected_id = $id;
            $dataedit = Practica::find($selected_id);
            if($dataedit!=null){
            //dd($dataedit->grados);
                $practica_titulo = $dataedit->titulo;
                $practica_grados = $dataedit->grados;
                $dias = $dataedit->dias;

                if($practica_grados->count()>0){
                    foreach($practica_grados as $losgrados){
                        if(!array_key_exists($losgrados->id,$ingrados)){
                            $ingrados[] = $losgrados->id;
                        }
                        
                    }
                }
            }
        }

        if($dias==null){
            $dias = '[]';
        }
    
        if($request->has('titulo')){
            //guardar titulo

            
            $nlink = str_replace(' ','_',$request->titulo);
            

            $newPractica = Practica::updateOrCreate([
                'id'=>$request->selected_id
            ],[
                'titulo'=>$request->titulo,
                'link'=>$nlink,
                'user_id'=>Auth::id(),
                'dias'=>json_encode($request->dias)
            ]);
            Practica_grado::where([
                'practica_id'=>$request->selected_id,
            ])->delete();
            $grados = $request->nivel;
            $arrsave = [];
            if(is_array($grados) && count($grados)>0){
                foreach ($grados as $elgrado) {
                    $arrsave[] = [
                        'practica_id'=>$newPractica->id,
                        'nivel_id'=>$elgrado
                        
                    ];
                }
                Practica_grado::insert($arrsave);
            }

            return back();
        }
        
        $practicas = Practica::where(['user_id'=>Auth::id()])->get();
        $niveles = Nivel::get();

        return view('practica.index',[
            'practicas'=>$practicas,
            'niveles'=>$niveles,
            'selected_id' => $selected_id,
            'practica_titulo'=>$practica_titulo,
            'ingrados'=>$ingrados,
            'dias'=>$dias
        ]);
    }
    public function get(){
      
        $conditional = [
            'nivel_id'=>Auth::user()->nivel_id
        ];
        
        $json = [];
        
        $temp = Practica::whereHas('grados', function($query) use ($conditional) {
            $query->where($conditional);
        })->get()->toArray();


        if(is_array($temp) && count($temp)>0){
            foreach($temp as $info){
             

                $start = $info['created_at'];
                $data = [];
                $data['title']=$info['titulo'];
                $data['url']='';//route('virtual',['id'=>$info['id']]);
                $data['daysOfWeek'] = ['1'];
                $data['target']='_blank';
                $data['startTime']= '10:45:00';
                $data['endTime']='12:45:00';
                $data['data']=[
                    'title'=>$info['titulo'],
                    //'grados'=>$string_grado
                ];
                //verificar streaming
                /*
                if(count(\explode('meet.google.com',$info['streaming']))>1){
                    $data['color'] = '#BFDBFE';
                }
                if(count(\explode('drive.google.com',$info['streaming']))>1){
                    $data['color'] = '#60A5FA';
                }
                if($info['streaming']==''){
                    $data['color'] = '#9CA3AF';
                }*/
                $data['color'] = '#9CA3AF';
                
                $json[] = $data;
            }
        }
        return \json_encode($json);
    }
    public function sendimagequestion(Request $request){
        if($request->has('file')){
           
            $name =$request->file->getClientOriginalName();
            $extension =$request->file->getClientOriginalExtension();
            //$title = user::find(Auth::user()->id)->teacher->title;
           
            $newName = uniqid() .'_'. $name;//$extension;
            //$file->move('storage\app\materials',$newName);
            $request->file->storeAs('/questions', $newName, $disk = 'public');
            
            $response = [];
            $response['name'] = $newName;
            $response['ext'] = $extension;
            return json_encode($response);
        }
    }
    public function responder(Request $request){
        Practica_answer::where([
            'practica_id'=>$request->practica_id,
            'student_id'=>Auth::id()
        ])->delete();

        $answers = json_decode($request->answers,true);
        $data = [];

        $identity =  Auth::user()->lastname . ', ' . Auth::user()->name;
        $student_id = Auth::id();
       
        $grado_id = Auth::user()->nivel_id;
        

        $total_points = 0;

        foreach ($answers as $answer) {

            

            $data[] = [
                'practica_id'=>$request->practica_id,
                'practica_question_id'=>$answer['question_id'],
                'answer'=>$answer['answer'],
                'alumno'=>$identity,
                'points'=>$answer['points'],
                'student_id'=>$student_id,
                'grado_id'=>$grado_id
            ];
            $total_points+=(int)$answer['points'];
        }

        $searchMyTask = Total_puntos::where([
            'tarea_id'=>$request->practica_id,
            'user_id'=>Auth::id()
        ])->first();

        if($searchMyTask!=null){
            //existe: actualizar
            $notab = json_decode($searchMyTask->puntos,true);
            $notab[] = [
                'nota'=>$total_points,
                'fecha'=>date('Y-m-d h:i:s')
            ];

            $searchMyTask->update([
                'puntos'=>json_encode($notab),
            ]);
        }else{
            $nota = [
                'nota'=>$total_points,
                'fecha'=>date('Y-m-d h:i:s')
            ];
            $notab = [];
            $notab[] = [
                'nota'=>$total_points,
                'fecha'=>date('Y-m-d h:i:s')
            ];

            Total_puntos::create([
                'tarea_id'=>$request->practica_id,
                'user_id'=>Auth::id(),
                'puntos'=>json_encode($notab),
                'grado_id'=>$grado_id,
                'alumno'=>$identity,
            ]);
        }

        

        Practica_answer::insert($data);

        return true;

    }
    public function getstudents(Request $request){

        $clase_id = $request->grado;

        $students = User::where(['nivel_id'=>$clase_id])->orderBy('apellido','desc')->get()->toArray();

        return json_encode($students);

    }
    public function getanswers(Request $request){
        
        $data = [];
        $arr_answer = [];
            
        $practica_id = $request->practica_id;
        $alumno = $request->alumno;

        //actualizacion, si solo eligieron el grado, jalar todas las respuestas de ese grado
        if($request->has('grado')){
            $total = Total_puntos::where([
                'grado_id'=>$request->grado,
                'tarea_id'=>$practica_id,
            ])->orderby('alumno','asc')->get();
            
            return view('practica.myanswers2',[
                'total'=>$total
            ]);
        }

        $answers = Practica_answer::where([
            'practica_id'=>$practica_id,
            'student_id'=>$alumno,
        ])->get()->toArray();

        $pq = Practica_question::where([
            'practica_id'=>$practica_id,
        ])->get();

        $arrquestions = [];

        if($pq->count()>0){
            foreach ($pq as $key => $valpq) {
                $arrquestions[$valpq->id] = $valpq;
            }
        }
      
        if(is_array($answers) && count($answers)>0){


            foreach ($answers as $answer) {
                $practica_question_id = $answer['practica_question_id'];
                //$setq = Practica_question::find($practica_question_id);

                $setq = null;
                if(array_key_exists($practica_question_id,$arrquestions)){
                    $setq = $arrquestions[$practica_question_id];
                }

                if($setq!=null){
                    $question = $setq->question;
                    $options = $setq->options;
                    $question_imagen = $setq->question_imagen;

                    $arr_answer[] = [
                        'question'=>$question,
                        'options'=>$options,
                        'question_imagen'=>$question_imagen,
                        'correct_answer'=>$setq->answer,
                        'answer'=>$answer['answer'],
                        'points'=>$answer['points']
                    ];
                }
            }
            return view('practica.myanswers',[
                'questions'=>$arr_answer,
                'admin'=>true
            ]);
        }else{
            return 'Aún sin respuestas';
        }

    }
    public function getanswer(Request $request){
        
        $data = [];
        $arr_answer = [];
            
        $practica_id = $request->practica_id;

        $answers = Practica_answer::where([
            'practica_id'=>$practica_id,
            'student_id'=>Auth::id(),
        ])->get()->toArray();

        $pq = Practica_question::where([
            'practica_id'=>$practica_id,
        ])->get();

        $arrquestions = [];

        if($pq->count()>0){
            foreach ($pq as $key => $valpq) {
                $arrquestions[$valpq->id] = $valpq;
            }
        }
        
      
        if(is_array($answers) && count($answers)>0){


            foreach ($answers as $answer) {
                
                $practica_question_id = $answer['practica_question_id'];
                //$setq = Practica_question::find($practica_question_id);
                $setq = null;
                if(array_key_exists($practica_question_id,$arrquestions)){
                    $setq = $arrquestions[$practica_question_id];
                }
                
                if($setq!=null){
                    $question = $setq->question;
                    $options = $setq->options;
                    $question_imagen = $setq->question_imagen;

                    $arr_answer[] = [
                        'question'=>$question,
                        'options'=>$options,
                        'question_imagen'=>$question_imagen,
                        'answer'=>$answer['answer'],
                        'correct_answer'=>$setq->answer,
                        'points'=>$answer['points']
                    ];
                }
            }
            return view('practica.myanswers',[
                'questions'=>$arr_answer,
                'admin'=>false
            ]);
        }else{
            return '';
        }

    }
    public function json(Request $request){
        $arr_total = [];
            

        $questions = Practica_question::where([
            ['practica_id','=',$request->practica_id],
            ['estado','<>','true']
        ])->get()->toArray();

        $practicaob = Practica::find($request->practica_id)->maximo;
        if($practicaob==null){
            $practicaob = 1000;
        }
        
        if(count($questions)>0){

            $counter_total = 0;

            shuffle($questions);

            foreach($questions as $quest){

                $arrOptions = json_decode($quest['options'],true);

                shuffle($arrOptions);

                $counter_total++;

                if($counter_total<=$practicaob){
                    $arr_total[] = [
                        'id'=>$quest['id'],
                        'question'=>$quest['question'],
                        'options'=>$arrOptions,
                        'answer'=>$quest['answer'],
                        'points'=>$quest['points'],
                        'time'=>$quest['time'],
                        'question_imagen'=>$quest['question_imagen'],
                    ];
                }

                
            }
        }

        $data['stringquestions'] = $arr_total;
        return json_encode($data);
    }
    function dropquest(Request $request){
        $id = $request->id;
        Practica_answer::where(['practica_question_id'=>$id])->delete();
        $el = Practica_question::find($id)->delete();
        return $el;
    }
    public function practica($id,$practica = null){
        
        $practica_id = $id;

        $exist = Practica::where(['id'=>$practica_id])->first();

        $grado = 0;

   
        $data = [];
        $data['selected_id'] = null;
        $data['practica_id'] = $practica_id;


        $data['practica'] = $exist->link;
        $data['titulo'] = $exist->titulo;
        $data['maximo'] = $exist->maximo;

        $data['classes'] = [];

        $niveles = Nivel::get();
        $data['classes'] = $niveles;

        return view('practica.create',$data);
        
    }
    public function practica2($id,$practica = null,$resuelto = 'false'){

        $practica_id = $id;

        $exist = Practica::where(['id'=>$practica_id])->first();

        $grado = 0;
        

   
        $data = [];
        $data['selected_id'] = null;
        $data['practica_id'] = $practica_id;

        $data['resuelto'] = $resuelto;


        $data['practica'] = $exist->link;
        $data['titulo'] = $exist->titulo;
        $data['maximo'] = $exist->maximo;

        $data['classes'] = [];

        $arr_total = [];

            $questions = Practica_question::where([
                ['practica_id','=',$practica_id],
                ['estado','<>','true']
            ])->get()->toArray();

            $practicaob = Practica::find($practica_id)->maximo;
            if($practicaob==null){
                $practicaob = 1000;
            }

            $student_data = User::where(['id'=>Auth::id()])->first();
            $grado_id = null;

            if($student_data!=null){
                $grado_id = $student_data->clase_id;
            }

            $grado = $grado_id;

           
            

            if(count($questions)>0){

                shuffle($questions);
                
                $counter_total = 0;

                foreach($questions as $quest){

                    $arrOptions = json_decode($quest['options'],true);
                    shuffle($arrOptions);
                    
                    $counter_total++;

                    if($counter_total<=$practicaob){
                        $arr_total[] = [
                            'id'=>$quest['id'],
                            'question'=>addslashes($quest['question']),
                            'options'=>$arrOptions,
                            'answer'=>$quest['answer'],
                            'points'=>$quest['points'],
                            'time'=>$quest['time'],
                            'question_imagen'=>$quest['question_imagen'],
                        ];
                    }
                    
                }
            }

            $data['stringquestions'] = $arr_total;
            /*
            if($grado!=null || Auth::user()->type=='teacher'){
                if($grado>11 || Auth::user()->type=='teacher'){
                    return view('practica.jugar2',$data);
                }
            }*/
            return view('practica.jugar',$data);
    }
    public function preguntas(Request $request){
        $questions = Practica_question::where([
            'practica_id'=>$request->practica_id,
        ])->get();

        return view('practica.preguntas',[
            'preguntas'=>$questions
        ]);
    }
    public function storequestion(Request $request){

        $arrOption = null;

        if(is_array($request->option) && count($request->option)>0){
            $arrOption = [];
            foreach($request->option as $option){
                if(trim($option)!=''){
                    $arrOption[] = trim($option);
                }
            }
            $arrOption = json_encode($arrOption);
        }

       
        $resultquestion = Practica_question::updateOrCreate([
            'id'=>$request->selected_id
        ],[
            'practica_id'=>$request->practica_id,
            'question'=>$request->question,
            'options'=>$arrOption,
            'answer'=>$request->answer,
            'points'=>$request->points,
            'time'=>$request->time,
            'question_imagen'=>$request->question_imagen,
        ]);

        return json_encode($resultquestion);
    }
    public function savemaximo(Request $request){
      
        try {
            $practica = Practica::find($request->id)->update([
                'maximo'=>$request->maximo
            ]);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function saveq(Request $request){
      
        try {
            Practica_question::find($request->idquestion)->update([
                'estado'=>$request->checked
            ]);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function eliminar(Request $request,$id){
        Practica_grado::where([
            'practica_id'=>$id
        ])->delete();
        Practica_answer::where([
            'practica_id'=>$id
        ])->delete();
        Practica_question::where([
            'practica_id'=>$id
        ])->delete();

        Practica::find($id)->delete();

        return redirect()->route('dashboard');
    }
}