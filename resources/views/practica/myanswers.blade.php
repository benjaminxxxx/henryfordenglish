@php
    $total_points= 0;
@endphp
    
<div class="content-answer bg-white shadow-md text-left w-full m-auto rounded-lg block mt-3 p-5 overflow-hidden">
    
    
    <div class="md:flex ">
        
        <div class="mt-5 w-full overflow-y-auto rounded-lg border">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            PREGUNTA
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            RESPUESTA CORRECTA
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            RESPUESTA ALUMNO
                        </th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            PUNTOS
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $answer)
                    @php
                        $total_points+=(int)$answer['points'];
                    @endphp
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="" style="min-width: 225px">
                                <p class="font-bold text-lg" style="max-width: 200px;word-break: break-word;">{{$answer['question']}}</p>
                                
                                @if($answer['question_imagen']!=null)
                                
                                @php
                                    $arrnombre = explode('.',$answer['question_imagen']);
                                    $ext = end($arrnombre);
                                    $str_img = '';

                                    $link = asset('material/questions') . '/'. $answer['question_imagen'];

                                    if($ext=='mp3'){
                                        $str_img = '<audio controls><source src="'.$link.'" type="audio/mpeg"></audio>';
                                    }else{
                                        $str_img = '<img src="'.$link.'" style="max-height:100px" />';
                                    }
                                @endphp
                                {!!$str_img!!}
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @php
                                $responsec = explode('|',$answer['correct_answer']);
                                $responsect = '<div class="">';
                                if (is_array($responsec) && count($responsec)>0) {
                                    foreach ($responsec as $correcta) {
                                        $ext = explode('.',$correcta);
                                        $ext_ = end($ext);
                                        $os = array('png','jpg','jpeg','gif');

                                        if (in_array($ext_,$os)) {
                                            $responsect.= '<img src="'.$correcta.'" style="max-height: 100px; display: inline-block; margin: 0 auto;">';
                                        }else{
                                            $responsect.= '<p>' . $correcta . '</p>';
                                        }
                                    }
                                }
                                $responsect.='</div>';
                                
                            @endphp
                            <p class="text-gray-900  text-left notranslate" style="max-width: 100px;word-break: break-word;">{!!$responsect!!}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            @php
                                $response = mb_strtolower($answer['answer']);
                                $ext = explode('.',$response);
                                $ext_ = end($ext);
                                $os = array('png','jpg','jpeg','gif');

                                if (in_array($ext_,$os)) {
                                    $response = '<img src="'.$response.'" style="max-height: 100px; display: inline-block; margin: 0 auto;">';
                                }
                            @endphp
                            <p class="text-gray-900  text-left notranslate" style="max-width: 100px;word-break: break-word;">{!!$response!!}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900  text-center">
                                {{$answer['points']}}
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="w-full text-center">
                <div class="to-center">
                    <div>
                        Puntos totales: <span class="puntaje-total">{{$total_points}}</span>
                        <p>
                            <button class="py-2 ver-solucion mt-3 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-purple-600 shadow-sm hover:bg-purple-500 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out" type="button">
                                VER SOLUCIÓN
                            </button>

                        </p>
                    </div>
                    
                </div>
                @if($admin==false)
                <button id="try" class="py-2 mt-3 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-purple-600 shadow-sm hover:bg-purple-500 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out" type="button">
                    VOLVER A INTENTARLO
                </button>

                <a href="{{route('dashboard')}}" class="py-2 mt-3 ml-3 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-purple-600 shadow-sm hover:bg-purple-500 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out" >
                    SALIR
                </a>
                @endif
            </div>
        </div>
    </div>
    
</div>