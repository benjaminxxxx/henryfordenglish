<?php 
$type = [
    'administrative'=>'Personal Administrativo',
    'student'=>'Estudiante',
    'teacher'=>'Docente'
]; 
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
        <style>
            .bg-galaxy{
                background: url("{{asset('image/galaxy.svg')}}") no-repeat;
                background-size: cover;
            }
            .alternative{
                padding: 3px 42px;
                background: #FFD200;
                border-bottom: 5px solid #F1A900;
                border-top: 4px solid #FCEF79;
                border-radius: 41px;
                width: 100%;
                margin-bottom: 11px;
                transition: all .2s ease-in-out;
                font-family: 'Lilita One', cursive;
                color: white;
                margin: 11px auto;
                display: block;
            }
            .alternative span{
                font-size: 24px;
                text-transform: uppercase;
                -webkit-text-stroke-width: 1px;
                -webkit-text-stroke-color: black;
            }
            .alternative:hover{
                cursor: pointer;
                background:#FFBA00;
                border-bottom:5px solid #FEEAB9;
                border-top:4px solid #FF9200;
            }
            .rounded-letter{
                background: #BF9D00;
                border: 2px solid #A48800;
                width: 38px;
                height: 38px;
                border-radius: 50%;
                line-height: 37px;
                text-align: center;
                display: inline-block;
                margin-right: 4px;
                font-family: 'Lilita One', cursive;
                color:white;
                font-size: 31px;
                text-transform: uppercase;
                -webkit-text-stroke-width: 1px;
                -webkit-text-stroke-color: black;
            }
            .btn-send-a{
                float: inherit;
                background: #BFFF00;
                border-radius: 53px;
                padding: 9px 36px;
                margin: 0 auto;
                display: block;
                margin-top: 8px;
                font-family: 'Lilita One', cursive;
                color: white;
                font-size: 31px;
                text-transform: uppercase;
                -webkit-text-stroke-width: 1px;
                -webkit-text-stroke-color: black;
                border-bottom: 4px solid #3F9C01;
                border-top: 4px solid #F0FFD0;
                transition: all .2s ease-in-out;
            }
            .btn-send-a:hover{
                background: #99cc00;
                border-bottom: 4px solid #9cff5b;
                border-top: 4px solid #649201;
            }
            .bg-question{
                background: url("{{asset('image/question.svg')}}") no-repeat;
                background-size: cover;
    display: block;
    min-height: 312px;
    max-width: 490px;
    width: 100%;
    padding: 43px 57px 0;
    color: #fff;
    margin: 0 auto;
                
            }
            .bg-question img{
                max-width: 100%;    max-height: 155px;
            }
            .bg-question p{
                font-family: 'Lilita One', cursive;
    font-size: 28px !important;
    text-transform: uppercase;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: black;
    /* max-width: 249px; */
    /* min-height: 100px; */
    max-height: 169px;
    /* overflow-x: auto; */
    word-break: break-word;
            }
            .bg-box{
                max-width: 636px;
                width: 100%;
                overflow: auto;
                padding: 33px 61px;
                border-radius: 38px;
                background: #00000073;
                max-height: 100vh;
            }
            .text-response{
                border-radius: 9px;
    border: 6px solid #f53181;
    font-family: 'Lilita One', cursive;
    color: #f43180 !important;
    font-size: 36px;
    text-transform: uppercase;
    -webkit-text-stroke-width: 2px;
    -webkit-text-stroke-color: #cc0656;
    line-height: 38px;
            }
            .fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
.fadeShadow{
    -webkit-animation-name: fadShadow;
  animation-name: fadShadow;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}
@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}
@keyframes fadShadow {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

/* Simple CSS3 Fade-in Animation */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}
            @media (max-width:900px){
              
                .btn-send-a {
                    padding: 1px 20px;
                    margin-top: 5px;
                    font-size: 26px;
                }
                .bg-box {
                    padding: 10px 13px;
                    border-radius: 0;
                }
                .bg-question {
                    min-height: 288px;
                    max-width: 450px;
                    padding: 40px 40px 28px;
                }
            }
        </style>
        <link rel="icon" type="image/png" href="{{url('image/logo.png')}}">

        <!-- Scripts -->
        <script src="{{asset('js/alpine.js')}}" defer></script>
        @yield('before')
    </head>
    <body class="font-sans antialiased">
        @yield('top')
        <div>
            <script src="{{asset('js/alpine.min.js')}}" defer></script>
            
            <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
            
                <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-60 transition duration-300 transform bg-dark-2 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
                    @include('snippets.menu')
                </div>
                <div class="flex-1 flex flex-col overflow-hidden min-h-screen">
                    
                    <header class="flex justify-between items-center py-2 px-6 bg-white">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </button>
            
                            @yield('header')

                            
                        </div>
                        @livewire('navigation-menu')
                    </header>
                    
                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 relative">
                        
                        @yield('content')
                        
                    </main>
                </div>
            </div>
        </div>


        @stack('modals')
        
        <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
        <script src="{{asset('js/all.min.js')}}"></script>
        <script src="{{asset('js/moment-with-locales.js')}}"></script>
        <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
        @yield('after')
        @livewireScripts
            
    </body>
</html>
