@php
    $total = 0;
    $sum = 0;
@endphp
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
    <div class="mt-5 w-full overflow-y-auto rounded-lg border">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        #
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        PREGUNTA
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        OPCIONES
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        RESPUESTA(S)
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        PUNTOS
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ACCIÓN
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($preguntas as $quest)
                    @php
                        
                        
                        if($quest->estado!='true'){
                            $total++;
                            $sum+=$quest->points;
                        }
                    @endphp
                    <tr>
                        <td>
                            @if($quest->estado!='true')
                                <p class="font-bold text-lg" style="max-width: 200px;word-break: break-word;">{{$total}}</p>
                            @endif
                        </td>
                        <td>
                            <p class="font-bold text-lg" style="max-width: 200px;word-break: break-word; text-align:left">{{$quest->question}}</p>
                            <p>
                                @if($quest->question_imagen!=null)
                                @php
                                    $arrnombre = explode('.',$quest->question_imagen);
                                    $ext = end($arrnombre);
                                    $str_img = '';

                                    $link = asset('material/questions') . '/'. $quest->question_imagen;

                                    if($ext=='mp3'){
                                        $str_img = '<audio controls><source src="'.$link.'" type="audio/mpeg"></audio>';
                                    }else{
                                        $str_img = '<img src="'.$link.'" style="max-height:100px" />';
                                    }
                                    echo $str_img;
                                @endphp
                                @endif
                            </p>
                        </td>
                        <td>
                            @if($quest->options!=null)
                            @php
                                $responseop = json_decode($quest->options,true);
                                if (is_array($responseop) && count($responseop)>0) {
                                    foreach ($responseop as $opcion) {
                                        $extop = explode('.',$opcion);
                                        $ext_op = end($extop);
                                        $osop = array('png','jpg','jpeg','gif');
                                        if (in_array($ext_op,$osop)) {
                                            echo  '<img src="'.$opcion.'" style="max-height: 50px; display: inline-block; margin: 0 auto;">';
                                        }else{
                                            echo '<p>' . $opcion . '</p>';
                                        }
                                    }
                                }
                            @endphp
                            @endif
                        </td>
                        <td>
                            @php
                                $responsec = explode('|',$quest->answer);
                                
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
                        <td><p class="font-bold text-lg" style="max-width: 200px;word-break: break-word;">{{$quest->points}}</p></td>
                        <td>
                            @php
                                $ischecked = '';
                                if($quest->estado=='true'){
                                    $ischecked = ' checked="checked" ';
                                }
                            @endphp
                            <input type="checkbox" name="" class="mr-2 setchangeestatus" {{$ischecked}} data-question="{{$quest->id}}">
                            <button type="button" data-id="{{$quest->id}}" style="white-space: nowrap;" class="drop-quest bg-red-600 text-sm  hover:bg-red-700 py-1 px-2 text-white mt-3 rounded">Eliminar</button>
                            <button type="button" 
                                    data-id="{{$quest->id}}" 
                                    data-question="{{$quest->question}}" 
                                    data-options='{{$quest->options}}'
                                    data-answer="{{$quest->answer}}" 
                                    data-points="{{$quest->points}}" 
                                    data-question_imagen="{{$quest->question_imagen}}" 
                                    style="white-space: nowrap;" class="edit-quest bg-indigo-600 text-sm  hover:bg-indigo-700 py-1 px-2 text-white mt-3 rounded">Editar</button>
                        </td>
                    </tr>
                
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="100%">
                        <p>PUNTOS TOTALES: {{$sum}}</p>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


