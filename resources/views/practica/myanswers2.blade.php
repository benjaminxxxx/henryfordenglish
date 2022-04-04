@php
    $total_points= 0;
@endphp
    
<div class="content-answer bg-white shadow-md text-left w-full m-auto rounded-lg block mt-3 p-5 overflow-hidden">
    
    <button id="update-list-notas" class="cursor-pointer py-2 px-3 rounded transition bg-green-500 text-white">
        Actualizar lista
    </button>
    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 mt-2">

        @if($total->count()>0)
                   
            @foreach ($total as $answer)
            <div class="mt-5 w-full overflow-y-auto rounded-lg border col-span-1">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th colspan="2" class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                {{$answer->alumno}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $puntos = json_decode($answer->puntos,true);
                        $total_questions = count($puntos);

                    @endphp
                    
                        @foreach($puntos as $punto)
                        <tr>
                            <td class="px-2 py-1 border-b border-gray-200 bg-white text-sm">
                                            
                                <p class="text-gray-900  text-center">
                                {{$punto['nota']}}
                                </p>
                            </td>
                            <td class="px-2 py-1 border-b border-gray-200 bg-white text-sm">
                        
                                <p class="text-gray-900  text-center" >
                                    {{$punto['fecha']}}
                                </p>
                            </td> 
                        </tr>
                        @endforeach
                    
                </table>
            </div>
            @endforeach
        @endif
    </div>
    
</div>