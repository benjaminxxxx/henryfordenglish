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
        <x-table-responsive>
            <thead>
                <tr>
                    <x-th value="N°" />
                    <x-th value="Estudiante" />
                    <x-th value="Lunes" />
                    <x-th value="Martes" />
                    <x-th value="Miercoles" />
                    <x-th value="Jueves" />
                    <x-th value="Viernes" />
                </tr>
            </thead>
            <tbody>
                @if($estudiantes!=null && $estudiantes->count()>0)
                    @foreach ($estudiantes as $indexe => $estudiante)
                    <tr>
                        <x-td>{{$indexe+1}}</x-td>
                        <x-td>{{$estudiante->apellido . ', ' . $estudiante->name}}</x-td>
                        <x-td></x-td>
                        <x-td></x-td>
                        <x-td></x-td>
                        <x-td></x-td>
                        <x-td></x-td>
                        <x-td></x-td>
                    </tr>        
                    @endforeach
                @endif
                
            </tbody>
        </x-table-responsive>
        {{print_r($puntajes)}}
    </x-panel>
</div>
