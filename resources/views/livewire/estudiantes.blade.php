<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-panel class="">
        <x-select wire:model="gradoseleccionado" class="mb-5">
            <option value="">Seleccionar grado</option>
            @foreach ($grados as $grado)
                <option value="{{$grado->id}}">{{$grado->grado}}</option>
            @endforeach
        </x-select>
        <hr>
        @php
            $textdias = ['Lunes','Martes','Miercoles','Jueves','Viernes'];
        @endphp
        <x-table-responsive>
            <thead>
                <tr>
                    <x-th rowspan="2" value="N°" />
                    <x-th rowspan="2" value="Estudiante" />
                    @foreach ($dias as $index => $dia)
                    <x-th colspan="{{count($dia)}}" value="{{$textdias[$index]}}" />
                    @endforeach
                </tr>
                <tr style="243px">
                    @foreach ($dias as $dia)
                        @foreach ($dia as $lapractica)
                        <x-th style="height: 150px" class="-rotate-90	" value="{{$lapractica}}" />
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if($estudiantes!=null && $estudiantes->count()>0)
                    @foreach ($estudiantes as $indexe => $estudiante)
                    <tr>
                        <x-td>{{$indexe+1}}</x-td>
                        <x-td>{{$estudiante->apellido . ', ' . $estudiante->name}}</x-td>
                        
                        @foreach ($dias as $index1 => $dia2)
                            @foreach ($dia2 as $index2 => $lapractica2)
                            <x-td>
                                @if(array_key_exists($estudiante->id,$estudiantes_data))
                                    @if(array_key_exists($index1,$estudiantes_data[$estudiante->id]))
                                        @if(array_key_exists($index2,$estudiantes_data[$estudiante->id][$index1]))
                            {{$estudiantes_data[$estudiante->id][$index1][$index2]}}

                                        @else
                                            - 
                                        @endif
                                    @else
                                        - 
                                    @endif
                                @else
                                    -
                                @endif
                            </x-td>
                            @endforeach
                        @endforeach
                        
                    </tr>        
                    @endforeach
                @endif
                
            </tbody>
        </x-table-responsive>
    </x-panel>
</div>
