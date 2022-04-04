@extends('layouts.admin3')

@section('header')
        
    <div class="flex items-center content-between">
        <div class="flex items-center">
            <span class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            Mis practicas
            </span> 
        </div> 
    </div>
@endsection

@section('content')
@php
    $input_class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5";
@endphp
<div class="py-4 px-3 relative">
    <div class="mx-auto sm:px-6 lg:px-8">
        <form  class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6" action="{{route('practica')}}" method="post">
          @csrf
          
          
          <input type="hidden" value="{{$selected_id}}" name="selected_id">
  
          <div class="block md:flex">
            <div class="flex-1 flex flex-col overflow-hidden py-5 pr-4">
              
                <label for="subject" class="block text-sm font-medium leading-5 text-gray-700">Agregar Practica</label>
                <div class="relative">
                    <input name="titulo" value="{{$practica_titulo}}" required class="{{$input_class}}">
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-4 gap-2">
                    @foreach ($niveles as $nivel)
                    <div class="col-span-1">
                        <x-label for="nivel-{{$nivel->id}}" class="flex items-center mt-3">
                    
                            @if (in_array($nivel->id,$ingrados))
                            <x-input type="checkbox" checked class="mr-3" style="margin-top:0 !important" name="nivel[]" id="nivel-{{$nivel->id}}" value="{{$nivel->id}}" />
                            @else
                            <x-input type="checkbox"  class="mr-3" style="margin-top:0 !important" name="nivel[]" id="nivel-{{$nivel->id}}" value="{{$nivel->id}}" />
                            @endif
                                {{$nivel->grado}}
                        </x-label>  
                    </div>
                    @endforeach
                </div>
                @php
                    $diasdelasemana = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
                    $indias = json_decode($dias,true);

                    if($indias==null){
                        $indias = [];
                    }
                  
                @endphp
                @foreach ($diasdelasemana as $indexd => $dia)
                <x-label for="dia-{{$indexd}}" class="flex items-center mt-3">
                    @if (in_array($indexd,$indias))
                    <x-input type="checkbox" checked class="mr-3" style="margin-top:0 !important" name="dias[]" id="dia-{{$indexd}}" value="{{$indexd}}" />
                    @else
                    <x-input type="checkbox"  class="mr-3" style="margin-top:0 !important" name="dias[]" id="dia-{{$indexd}}" value="{{$indexd}}" />
                    @endif
                    {{$dia}}
                </x-label>
                @endforeach
              
                <div class="w-full text-right mt-5">
                    <button  type="submit" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-purple-600 shadow-sm hover:bg-purple-500 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out">
                      Agregar Practica
                    </button> 
                  </div>  
            </div>
            
          </div>
          
    
        </form>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-5">
            @if($practicas->count()>0)
            <x-table-responsive>
                <thead>
                    <tr>
                     <x-th value="N°" />
                     <x-th class="text-left" value="Practica" />
                     <x-th value="Acciones" />
                    </tr>
                 </thead>
                 <tbody>
                @foreach($practicas as $index => $practica)
                    
                        <tr>
                            <x-td class="text-center">
                                {{$index+1}}
                            </x-td>
                            <x-td>
                                {{$practica->titulo}}
                            </x-td>
                            <x-td>
                                <a target="_blank" href="{{route('practicar',['id'=>$practica->id])}}" class="bg-white hover:bg-yellow-500 inline-block mr-6 overflow-hidden border sm:rounded-lg p-2">
                                    IR
                                </a>
                                <a href="{{route('practica.editar',['id'=>$practica->id])}}" class="bg-green-600 hover:bg-green-500 inline-block mr-6 overflow-hidden border sm:rounded-lg p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 bg-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="{{route('practica.eliminar',['id'=>$practica->id])}}" class="bg-red-600 hover:bg-red-500 inline-block mr-6 overflow-hidden border sm:rounded-lg p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 bg-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                      </svg>
                                </a>
                            </x-td>
                        </tr>
                    
                    
                @endforeach
            </tbody>
            </x-table-responsive>
            @else
            <p>Aún sin practicas</p>
            @endif
        </div>
    </div>
  </div>
@endsection
@section('after')
<script>
    
    jQuery(document).ready(function($){
       
    });
</script>
@endsection