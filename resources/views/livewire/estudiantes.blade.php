<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-panel class="">
        <x-select wire:model="gradoseleccionado" class="mb-5">
            <option value="">Seleccionar grado</option>
            @foreach ($grados as $grado)
                <option value="{{$grado->id}}">{{$grado->grado}}</option>
            @endforeach
        </x-select>
        <x-input class="ml-2" type="text" wire:model="estudiante" />
        <hr>
       
        <x-table-responsive>
            <thead>
                <tr>
                    <x-th rowspan="2" value="N°" />
                    <x-th rowspan="2" value="Estudiante" />
                    @foreach ($dias as $index => $dia)
                    <x-th colspan="{{count($dia)}}" value="{{$textdias[$index]}}" />
                    @endforeach
                    <x-th rowspan="2" value="Acciones" />
                </tr>
                <tr >
                    @foreach ($dias as $dia)
                        @foreach ($dia as $lapractica)
                        <x-th style="max-width:120px; word-wrap:break-word" class="" value="{{$lapractica}}" />
                        @endforeach
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if($estudiantes!=null && $estudiantes->count()>0)
                    @foreach ($estudiantes as $indexe => $estudiante)
                    <tr>
                        <x-td>{{$indexe+1}}</x-td>
                        @php
                            $apellido_arr = explode(' ',$estudiante->apellido);
                            $apellido_s = mb_strtoupper($apellido_arr[0]);

                            $nombre_arr = explode(' ',$estudiante->name);
                            $nombre_s = mb_strtoupper($nombre_arr[0]);
                            
                        @endphp
                        <x-td>{{$apellido_s . ', ' . $nombre_s}} <span style="display:none">[{{$estudiante->dni}}]</span></x-td>
                        
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
                        <x-td>
                            <div class="flex items-center">
                                <x-select name="gradoporseleccionar" style="margin: 0 !important;padding: 4px; max-width:120px"  onchange="Livewire.emit('change',{{$estudiante->id}},this.value)" >
                                <option value="">Seleccionar grado</option>
                                @foreach ($grados as $grado)
                                    <option value="{{$grado->id}}" {{(($estudiante->nivel_id==$grado->id)?'selected':'')}}>{{$grado->grado}}</option>
                                @endforeach
                            </x-select>
                            <x-danger-button style="font-size:11px; word-break:no-wrap; margin-left:3px" onclick="Livewire.emit('drop',{{$estudiante->id}})" type="button" >
                                x
                            </x-danger-button>
                            </div>
                            
                        </x-td>
                    </tr>        
                    @endforeach
                @endif
                
            </tbody>
        </x-table-responsive>
    </x-panel>
</div>
