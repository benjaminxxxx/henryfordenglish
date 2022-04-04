<?php

use App\Models\Total_puntos;
use App\Models\Practica;

$questions = Total_puntos::where([
    'user_id'=>Auth::id(),
])->orderby('updated_at','asc')->get();

$arr_quest = [];

if($questions->count()>0){
    foreach ($questions as $quest) {
        $qu = Practica::find($quest->tarea_id);
        if($qu!=null){
            $arr_quest[] = [
                'titulo'=>$qu->titulo,
                'link'=>$qu->link,
                'id'=>$qu->id,
            ];
        }
    }
}

?>
<div class="flex items-center sidebar-p-a bg-darker sidebar-account py-3 px-4">
    <div class="flex items-center  text-body">
        <div class="avatar w-12 h-12 mr-2">
            <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar" class="rounded-full p-1 bg-darker border-1">
        </div>
        <div class="leading-none">

            <div class="mb-1"><strong class="text-white bold text-sm">{{ Auth::user()->name }}</strong></div>
            
            <small class="text-muted text-xs text-white">{{array_key_exists(Auth::user()->type,$type)?$type[Auth::user()->type]:'Sin Asignar'}}</small>
        </div>
    </div>
</div>

<nav class="mt-10">
    @if(Auth::user()->type!='administrative')
    <x-nav-link href="{{ route('inicio') }}" :active="request()->routeIs(['inicio'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span class="mx-3">Inicio</span>
    </x-nav-link>
    @endif
    @if(Auth::user()->type=='teacher')
    
    
    <x-nav-link href="{{ route('teacher.classes.create') }}" :active="request()->routeIs(['teacher.classes.create'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
        </svg>
        <span class="mx-3">Programar clase</span>
    </x-nav-link>
    <x-nav-link href="{{ route('teacher.classes') }}" :active="request()->routeIs(['teacher.classes'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="mx-3">Mis clases</span>
    </x-nav-link>
    <x-nav-link href="{{ route('practica') }}" :active="request()->routeIs(['practica'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="mx-3">Crear practica</span>
    </x-nav-link>
    <!--
    <x-nav-link href="{{ route('classes.puntuaciones') }}" :active="request()->routeIs(['classes.puntuaciones'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="mx-3">Ver puntuaciones</span>
    </x-nav-link>-->
    <x-nav-link href="{{ route('teacher.areas') }}" :active="request()->routeIs(['teacher.areas'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
          </svg>
        <span class="mx-3">Mis areas</span>
    </x-nav-link>
    <x-nav-link href="{{ route('estudiantes') }}" :active="request()->routeIs(['estudiantes'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        <span class="mx-3">Estudiantes</span>
    </x-nav-link>
    <x-nav-link href="{{ route('teacher.videos') }}" :active="request()->routeIs(['teacher.videos'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
        </svg>
        <span class="mx-3">Videos de espera</span>
    </x-nav-link>

    <x-nav-link href="https://drive.google.com/drive/my-drive" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 1443.061 1249.993"><path fill="#3777e3" d="M240.525 1249.993l240.492-416.664h962.044l-240.514 416.664z"></path><path fill="#ffcf63" d="M962.055 833.329h481.006L962.055 0H481.017z"></path><path fill="#11a861" d="M0 833.329l240.525 416.664 481.006-833.328L481.017 0z"></path></svg>
        <span class="mx-3">Mis videos Drive</span>
    </x-nav-link>

    <x-nav-link href="{{ route('drive') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 1443.061 1249.993"><path fill="#3777e3" d="M240.525 1249.993l240.492-416.664h962.044l-240.514 416.664z"></path><path fill="#ffcf63" d="M962.055 833.329h481.006L962.055 0H481.017z"></path><path fill="#11a861" d="M0 833.329l240.525 416.664 481.006-833.328L481.017 0z"></path></svg>
        <span class="mx-3">Obtener grabaciones</span>
    </x-nav-link>

    <x-nav-link href="{{ route('registros') }}" target="_blank" target="_blank">
        <img src="{{url('image/excel.svg')}}" class="w-6 h-6" alt="">
        <span class="mx-3">Registros [formatos]</span>
    </x-nav-link>

    @endif

    @if(Auth::user()->type=='student')
    
    
    <!--<x-nav-link href="{{ route('student.mytasks') }}" :active="request()->routeIs(['student.mytasks'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        <span class="mx-3">Ver mis tareas</span>
    </x-nav-link>-->
    
    @if(count($arr_quest)>0)
    <h2 style="    padding: 27px 8px 3px 24px;color: #e0e0e0;font-size: 14px;font-weight: 800;">Tarea creada por los docentes</h2>
        @foreach($arr_quest as $ques)
        <x-nav-link href="{{route('practicar',['id'=>$ques['id'],'practica'=>$ques['link']])}}">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <span class="mx-3">{{$ques['titulo']}}</span>
        </x-nav-link>
        @endforeach
    @endif

    @endif

    @if(Auth::user()->type=='administrative')
    
    
    <x-nav-link href="{{ route('students') }}" :active="request()->routeIs(['students'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        <span class="mx-3">Estudiantes</span>
    </x-nav-link>
    <x-nav-link href="{{ route('teachers') }}" :active="request()->routeIs(['teachers'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span class="mx-3">Profesores</span>
    </x-nav-link>
    <x-nav-link href="{{ route('seguimiento') }}" :active="request()->routeIs(['seguimiento'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        <span class="mx-3">Seguimiento</span>
    </x-nav-link>
    <x-nav-link href="{{ route('niveles') }}" :active="request()->routeIs(['niveles'])">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <span class="mx-3">Niveles</span>
    </x-nav-link>

    @endif


    
</nav>