<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="p-2 md:p-10 bg-gray-100">
                <div id="calendar"></div>
                    <x-table-responsive>
                        <thead>
                            <tr>
                                <x-th value="Lunes" />
                                <x-th value="Martes" />
                                <x-th value="Miercoles" />
                                <x-th value="Jueves" />
                                <x-th value="Viernes" />
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($semanas as $dias)
                                <x-td>
                                    @if (is_array($dias) && count($dias)>0)
                                        @foreach ($dias as $diass)
                                        @php
                                            $dia = $diass['practica'];
                                            $estaresuelto = $diass['estaresuelto'];
                                            $estilo = '';
                                            $estatxt = 'false';
                                            $nota = $diass['nota'];

                                            if($estaresuelto){
                                                $estilo = 'text-green-600';
                                                $estatxt = 'true';
                                            }
                                        @endphp
                                            <x-box class="">
                                                <a class="{{$estilo}}" href="{{route('practicar.accion',['id'=>$dia->id,'practica'=>$dia->link,'resuelto'=>$estatxt])}}">
                                                    <p>{{$dia->titulo}}</p>
                                                    @if($estaresuelto)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                      </svg>
                                                      {{$nota}}
                                                    @else
                                                    Falta
                                                    @endif
                                                </a>
                                                
                                            </x-box>
                                        @endforeach
                                    @endif
                                </x-td>
                                @endforeach
                            </tr>
                        </tbody>
                    </x-table-responsive>
            </main>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/locales-all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(function() {

            var link = "{{route('practica.get')}}";

            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
            
                timeZone: 'UTC',
                locale: 'es',
                hiddenDays: [ 0, 6 ],
                initialView: 'timeGridWeek',
                height:460,
                //expandRows:true,
                allDaySlot:false,
                events: link,
                eventContent: function(arg) {

                    let div = document.createElement('div')

                    var data = arg.event.extendedProps.data;
                    console.log(arg);
                    
                    var elements = '<h1 style="display:inline-block">sdfff</h1>'
                    
                    elements+= '<div style="float: right;">sdf</div>';
                    elements+= '<p>' + arg.event.title + '</p>';
                    elements+= '<small class="flex">' + data.start + ' - ' + data.end + '</small>';
                    div.innerHTML = elements;

                    let arrayOfDomNodes = [ div ]
                    return { domNodes: arrayOfDomNodes }
                },
                editable: true,
                selectable: false
            });

            //calendar.render();

        });
        
    </script>

@livewireScripts
</html>
