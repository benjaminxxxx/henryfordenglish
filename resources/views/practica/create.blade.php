@extends('layouts.admin3')

@section('header')
        
    <div class="flex items-center content-between">
        <div class="flex items-center">
            <span class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            PRACTICA: {{$titulo}}
            </span> 
            <a href="{{route('practica')}}" class="ml-2 py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 shadow-sm hover:bg-green-700 focus:outline-none focus:shadow-outline-blue active:bg-green-600 transition duration-150 ease-in-out">
                <- Volver
            </a>
        </div> 
    </div>
@endsection

@section('content')
@php
    $link_button = 'py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 shadow-sm hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out';
@endphp
<style>
    .deleoption{
        position: absolute;
        right: 40px;
        top: 0;
        height: 100%;
        padding: 6px 8px;
        font-weight: bold;
        font-size: 29px;
        color: #ff1d1d;
        line-height: 25px;
        cursor: pointer
    }
    .imagen_option{
        position: absolute;
        right: 60px;
        top: 0;
        height: 100%;
        line-height: 25px;
        cursor: pointer
    }
    .checkoption{
        position: absolute;
        right: 12px;
        top: 10px;
        height: 20px;
        width: 20px;

        border: 2px solid #2563EB;
    }
    .deleoption:hover{
        background:rgb(223, 223, 223);
    }
    .selector_link{
        padding: 7px 21px;
        text-align: center;
        font-size: 17px;
        font-weight: bold;
        color: #3777e3;
        user-select: all;
        border: 2px solid;
        background: white;
    }
    .btn-link{
        font-size: 14px;
        padding: 5px 24px;
        display: inline-block;
        background: #ff4646;
        color: #fff;
        border-radius: 6px;
        margin-top: 6px;
    }
    .btn-link:hover{
        background: #ff5b5b;
    }
</style>
@php
    $input_class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5";
@endphp

<div class="px-6">
	<!--actual component start-->
	<div x-data="setup()">
		<ul class="flex justify-center items-center my-4">
			<template x-for="(tab, index) in tabs" :key="index">
				<li class="cursor-pointer py-2 px-4 text-gray-500 border-b-8"
					:class="activeTab===index ? 'text-green-500 border-green-500' : ''" @click="activeTab = index"
					x-text="tab"></li>
			</template>
		</ul>

		<div class="p-16 text-center mx-auto border">
			<div x-show="activeTab===0">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <label for="answer" class="block text-sm font-medium leading-5 text-gray-700">Copia este enlace para compartirlo a los estudiantes, puedes abrirlo para verificar que todo este en orden</label>
                    <div class="flex items-center">
                        <input type="text" onClick="this.select();" class="w-full selector_link rounded" value="{{route('practicar.accion',['id'=>$practica_id,'practica'=>$practica])}}">
                        <a target="_blank" class="{{$link_button}}" style="margin-left: 10px; " href="{{route('practicar.accion',['id'=>$practica_id,'practica'=>$practica])}}">ABRIR PRACTICA</a>
                    </div>
                </div>

                <form  type="multipart" id="frm-create-question" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mt-5" enctype="multipart/form-data" action="{{route('practica.storequestion')}}" method="post">
                    @csrf
                    
                    
                    <input type="hidden" value="{{$selected_id}}" name="selected_id">
                    <input type="hidden" value="{{$practica_id}}" name="practica_id">
            
                    <div class="block md:flex">
                      <div class="flex-1 flex flex-col overflow-hidden py-5 pr-4">
                        
                        <div class="grid grid-cols-2 xl:grid-cols-4 gap-6 text-left">
                              <div class="col-span-2">
                                  <div>
                                      <label for="question" class="block text-sm font-medium leading-5 text-gray-700">Agregar pregunta</label>
                                      <div class="relative">
                                          <input name="question" id="pasteArea" required class="{{$input_class}}">
                                          <div class="absolute right-0 top-0">
                                              <div class="overflow-hidden relative ">
                                                  <button type="button" class="text-gray-800 hover:bg-red-600 pointer font-bold py-2 px-4 inline-flex items-center">
                                                  <svg aria-hidden="true" class="w-6 h-6" focusable="false" data-prefix="fal" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-image fa-w-16 fa-3x"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm16 336c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V112c0-8.822 7.178-16 16-16h416c8.822 0 16 7.178 16 16v288zM112 232c30.928 0 56-25.072 56-56s-25.072-56-56-56-56 25.072-56 56 25.072 56 56 56zm0-80c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm207.029 23.029L224 270.059l-31.029-31.029c-9.373-9.373-24.569-9.373-33.941 0l-88 88A23.998 23.998 0 0 0 64 344v28c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-92c0-6.365-2.529-12.47-7.029-16.971l-88-88c-9.373-9.372-24.569-9.372-33.942 0zM416 352H96v-4.686l80-80 48 48 112-112 80 80V352z" class=""></path></svg>
                                                  
                                                  </button>
                                                  <input accept="audio/mp3,image/png, image/gif, image/jpeg" class="cursor-pointer absolute block opacity-0 inset-0 " onchange="file_question_imagen(this)" type="file" >
                                              </div>
                                          </div>
                                          <input type="hidden" name="question_imagen">
                                      </div>
                                      <div id="question_image_preview" class="question_image_preview"></div>
                                  </div>
                                  <div class="mt-2">
                                      <label for="options" class="block text-sm font-medium leading-5 text-gray-700">Agregar opciones</label>
                                      <div id="set-options">
          
                                      </div>
                                     
                                  </div>
                              </div>
                              <div class="col-span-2">
                                  <div>
                                      <label for="answer" class="block text-sm font-medium leading-5 text-gray-700">Respuesta</label>
                                      <input type="text" name="answer"  class="{{$input_class}}">
                                  </div>
                                  <div class="mt-2">
                                      <label for="points" class="block text-sm font-medium leading-5 text-gray-700">Puntos</label>
                                      <input name="points" type="number" class="{{$input_class}}">
                                  </div>
                                  <div class="mt-2 hidden">
                                    <label for="time" class="block text-sm font-medium leading-5 text-gray-700">Tiempo (en segundos)</label>
                                    <input name="time" type="number" class="{{$input_class}}">
                                  </div>
                              </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="w-full text-right">
                        <input type="text" value="{{$maximo}}" placeholder="Cantidad m??xima" class="mr-2 setmaximo py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" >
                        <button  type="submit" id="sendbutton" class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-purple-600 shadow-sm hover:bg-purple-500 focus:outline-none focus:shadow-outline-blue active:bg-purple-600 transition duration-150 ease-in-out">
                        Agregar pregunta
                      </button> 
                    </div>  
              
                </form>
                <div id="preguntas"></div>
            </div>
			<div x-show="activeTab===1">
                <form action="#" id="search-form" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6" method="get">
                    <div class="flex items-center justify-center">
                        <label class="block">
                            <span class="block text-gray-700 text-sm font-bold mb-2">Grado</span>
                            <select onchange="getstudents();" name="grado" class="block appearance-none w-44 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Buscar por grado</option>
                                @foreach($classes as $aula)
                                <option value="{{$aula->id}}">{{$aula->grado}}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-2 sm:mt-0 sm:ml-4">
                            <span class="block text-gray-700 text-sm font-bold mb-2">Alumno</span>
                            <select  onchange="search();" name="alumno" class="block appearance-none w-44 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Elgir primero al grado</option>
                                
                            </select>
                        </label>
                    </div>
                    
                </form>
                <div id="respuestas"></div>
            </div>
		</div>

		<ul class="flex justify-center items-center my-4">
			<template x-for="(tab, index) in tabs" :key="index">
				<li class="cursor-pointer py-3 px-4 rounded transition"
					:class="activeTab===index ? 'bg-green-500 text-white' : ' text-gray-500'" @click="activeTab = index"
					x-text="tab"></li>
			</template>
		</ul>
		
	</div>
	<!--actual component end-->
</div>

<script>
	function setup() {
    return {
      activeTab: 0,
      tabs: [
          "PREGUNTAS",
          "RESPUESTAS"
      ]
    };
  };
</script>
@endsection
@section('after')
<script>
    function getstudents(){
        
        var grado = $('[name="grado"] :selected').val();
        var practica_id ="{{$practica_id}}";
        
        if(grado.trim()!=''){
            //
            $.ajax({
                url:"{{route('practica.getstudents')}}",
                method:'get',
                dataType:'json',
                data:{
                    grado:grado
                },
                success:function(data){

                    $('[name="alumno"]').html('');
                    $('[name="alumno"]').append($('<option>').val('').text('Elegir al estudiante'));
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        $('[name="alumno"]').append($('<option>').val(element.id).text(element.apellido + ', ' +element.name));
                    }
                    
                },
                error:function(data){
                    console.log(data);
                }
            });

            $.ajax({
                url:"{{route('practica.getanswers')}}",
                method:'get',
                data:{
                    grado:grado,
                    practica_id:practica_id
                },
                success:function(data){
                    $('#respuestas').html(data);
                },
                error:function(data){
                    console.log(data);
                }
            });
        }else{
            $('[name="alumno"]').val('');
        }
    }
    function search(){

        var grado = $('[name="grado"] :selected').val();
        var alumno = $('[name="alumno"] :selected').val();
        var practica_id ="{{$practica_id}}";

        $('#respuestas').html('');

        if(grado.trim()!='' && alumno.trim()!=''){
            //
        
            console.log(alumno + ' - ' + practica_id);
            $.ajax({
                url:"{{route('practica.getanswers')}}",
                method:'get',
                data:{
                    alumno:alumno,
                    practica_id:practica_id
                },
                success:function(data){
                    $('#respuestas').html(data);
                },
                error:function(data){
                    console.log(data);
                }
            });
        }
    }
    function file_question_imagen(file){
        
        var files = $(file)[0].files;

        var token = "{{ csrf_token() }}";

        if(files.length > 0 ){

            var xhr=new XMLHttpRequest();

            xhr.onload=function(e) {
                if(this.readyState === 4) {
                    console.log(JSON.parse(e.target.responseText));
                    //question_image_preview
                    var data = JSON.parse(e.target.responseText);
                    $('[name="question_imagen"]').val(data.name);
                    checkquestion_imagen();
                    
                }else{
                    console.log(this.readyState);
                }
            };
            
            var fd=new FormData();

            fd.append("file",files[0]);
            fd.append("_token",token);
            xhr.open("POST","{{route('sendimagequestion')}}",true);
            xhr.send(fd);

        }
    }

    function file_question_imagen_op(file){
        
        var files = $(file)[0].files;
        var parent = $(file).parents('.pr-relative');

        var token = "{{ csrf_token() }}";

        if(files.length > 0 ){

            var xhr=new XMLHttpRequest();

            xhr.onload=function(e) {
                if(this.readyState === 4) {
                   
                    var data = JSON.parse(e.target.responseText);
                  
                    var link = "{{asset('material/questions') . '/'}}" + data.name;
                    $(parent).find('[name="option[]"]').val(link);
                    $(parent).find('.imagen_option_preview').html('<img src="'+link+'" style="max-height:100px" />');
                    
                    checkmaxinput();
                    checkanswer();
                    
                }else{
                    console.log(this.readyState);
                }
            };
            
            var fd=new FormData();

            fd.append("file",files[0]);
            fd.append("_token",token);
            xhr.open("POST","{{route('sendimagequestion')}}",true);
            xhr.send(fd);

        }
    }

    function getOption(index){
        var div = '<div class="w-full pr-relative">';
        div+= '<div class="relative">';
        div+= '<input type="text" autocomplete="off" style="    padding-right: 124px !important;" placeholder="Coloca una opci??n" name="option[]"  class="{{$input_class}}"><div class="imagen_option_preview"></div>';
        if(index!=1){
            div+= '<a href="#" class="deleoption">&times;</a>';
        }

        div+= '<div class="imagen_option">';
        div+= '<div class="overflow-hidden relative ">';
        div+= '<button type="button" class="text-gray-800 hover:bg-red-600 pointer font-bold py-2 px-4 inline-flex items-center">';
        div+= '<svg aria-hidden="true" class="w-6 h-6" focusable="false" data-prefix="fal" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-image fa-w-16 fa-3x"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm16 336c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V112c0-8.822 7.178-16 16-16h416c8.822 0 16 7.178 16 16v288zM112 232c30.928 0 56-25.072 56-56s-25.072-56-56-56-56 25.072-56 56 25.072 56 56 56zm0-80c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm207.029 23.029L224 270.059l-31.029-31.029c-9.373-9.373-24.569-9.373-33.941 0l-88 88A23.998 23.998 0 0 0 64 344v28c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-92c0-6.365-2.529-12.47-7.029-16.971l-88-88c-9.373-9.372-24.569-9.372-33.942 0zM416 352H96v-4.686l80-80 48 48 112-112 80 80V352z" class=""></path></svg>';
        div+= '</button>';
        div+= '<input accept="image/png, image/gif, image/jpeg" class="cursor-pointer absolute block opacity-0 inset-0 " onchange="file_question_imagen_op(this)" type="file" >';
        div+= '</div>';
        div+= '</div>';
        
        div+= '<input name="setrespose[]" type="checkbox" class="checkoption">';
        div+= '</div>';
        div+= '';
        div+= '</div>';

        $('#set-options').append(div);
    }
    function putOption(index,value,ischecked){
        var div = '<div class="w-full pr-relative">';
        div+= '<div class="relative">';
        div+= '<input type="text" autocomplete="off" value="'+value+'" style="    padding-right: 124px !important;" placeholder="Coloca una opci??n" name="option[]"  class="{{$input_class}}"><div class="imagen_option_preview"></div>';
        if(index!=1){
            div+= '<a href="#" class="deleoption">&times;</a>';
        }

        div+= '<div class="imagen_option">';
        div+= '<div class="overflow-hidden relative ">';
        div+= '<button type="button" class="text-gray-800 hover:bg-red-600 pointer font-bold py-2 px-4 inline-flex items-center">';
        div+= '<svg aria-hidden="true" class="w-6 h-6" focusable="false" data-prefix="fal" data-icon="image" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-image fa-w-16 fa-3x"><path fill="currentColor" d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm16 336c0 8.822-7.178 16-16 16H48c-8.822 0-16-7.178-16-16V112c0-8.822 7.178-16 16-16h416c8.822 0 16 7.178 16 16v288zM112 232c30.928 0 56-25.072 56-56s-25.072-56-56-56-56 25.072-56 56 25.072 56 56 56zm0-80c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm207.029 23.029L224 270.059l-31.029-31.029c-9.373-9.373-24.569-9.373-33.941 0l-88 88A23.998 23.998 0 0 0 64 344v28c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12v-92c0-6.365-2.529-12.47-7.029-16.971l-88-88c-9.373-9.372-24.569-9.372-33.942 0zM416 352H96v-4.686l80-80 48 48 112-112 80 80V352z" class=""></path></svg>';
        div+= '</button>';
        div+= '<input accept="image/png, image/gif, image/jpeg" class="cursor-pointer absolute block opacity-0 inset-0 " onchange="file_question_imagen_op(this)" type="file" >';
        div+= '</div>';
        div+= '</div>';
        console.log(ischecked);
        if(ischecked==true){
            div+= '<input name="setrespose[]" checked="checked" type="checkbox" class="checkoption">';    
        }else{
            div+= '<input name="setrespose[]" type="checkbox" class="checkoption">';
        }
        div+= '</div>';
        div+= '';
        div+= '</div>';

        $('#set-options').append(div);
    }
    function checkmaxinput(){

        var totalempty = 0;

        $('[name="option[]"]').each(function(index,eval){

            

            if($(eval).val().trim()==''){
                totalempty++;
            }
        });

        if(totalempty==0){
            getOption();
        }
    }
    function checkanswer(){
        var answers = [];
        $('[name="setrespose[]"]').each(function(index,eval){
            if($(eval).is(':checked')){
                var valor = $(eval).siblings('[name="option[]"]').val().trim();
                answers.push(valor);
            }
        });

        $('[name="answer"]').val(answers.join('|'));

    }
    function getAllQuestions(){
        
        var practica_id = "{{$practica_id}}";
        
        $.ajax({
            type: "get",
            url: "{{route('practica.preguntas')}}",
            data:{
                practica_id:practica_id
            },
            success:function(data){
                
                $('#preguntas').html(data);
            },
            error:function(errordata){
                var serverResponse = JSON.parse(errordata.responseText);
                
                if(serverResponse.message=='Unauthenticated.'){
                    location.href="{{route('login')}}";
                }
            }
        });
    }
    function checkquestion_imagen(){
        var imagen = $('input[name="question_imagen"]').val();
        if(imagen.trim()!=''){
            var ext = imagen.split('.').pop();
            var link = "{{asset('material/questions') . '/'}}" + imagen;
            console.log(ext);
            if(ext=='mp3'){
                        
                $('.question_image_preview').html('<audio controls><source src="'+link+'" type="audio/mpeg"></audio>');
            }else{
                $('.question_image_preview').html('<img src="'+link+'" style="max-height:100px" />');
            }
            $('.question_image_preview').append('<a href="#" class="eliminar_imagen_question btn-link">Eliminar</a>');
        }
    }

    jQuery(document).ready(function($){
       
        getOption(1);

        getAllQuestions();

        $('.setmaximo').on('keyup',function(){
            
            var maximo = $(this).val();

            $.ajax({
                type: "get",
                url: "{{route('practica.savemaximo')}}",
              
                data: {
                    id:"{{$practica_id}}",
                    maximo:maximo,
                },
                success:function(data){
                    getAllQuestions();
                },
                error:function(errordata){
                    console.log(errordata.responseText);
                }
            });
        });

        $('main').on('change','.setchangeestatus',function(){
            
            var checked = $(this).is(':checked');
            var idquestion = $(this).data('question');
console.log(idquestion);
            $.ajax({
                type: "get",
                url: "{{route('practica.saveq')}}",
                data: {
                    idquestion:idquestion,
                    checked:checked,
                },
                success:function(data){
                    console.log(data);
                    getAllQuestions();
                },
                error:function(errordata){
                    console.log(errordata.responseText);
                }
            });


        });

        $('#see-answers').on('click',function(e){
            e.preventDefault();
            $('.show-questions').removeClass('hidden');
            $('.show-answers').addClass('hidden');
        });
        $('#see-questions').on('click',function(e){
            e.preventDefault();
            $('.show-questions').addClass('hidden');
            $('.show-answers').removeClass('hidden');
        });

        
        
        $(document).on('keyup','[name="option[]"]',function(){
            checkmaxinput();
            checkanswer();
        });

        $(document).on('click','#update-list-notas',function(){
            $('#respuestas').html('Cargando...');
            getstudents();
        });
       
        $(document).on('click','[name="setrespose[]"]',function(){
            
            checkanswer();
        });

        $(document).on('click','.drop-quest',function(e){
            e.preventDefault();


            var id = $(this).data('id');
            var tbn = $(this);

            $.ajax({
                type: "get",
                url: "{{route('practica.dropquest')}}",
                dataType: "json",
                data: {//falta pasar los campos y olvide poner el area
                    id:id
                },
                success:function(data){
                    console.log(data);
                    $(tbn).parents('tr').remove();
                },
                error:function(errordata){
                    console.log(errordata.responseText);
                }
            });
        });

        $(document).on('click','.edit-quest',function(e){
            e.preventDefault();

            $('#sendbutton').html('Actualizar pregunta');

            var id = $(this).data('id');
            var question = $(this).data('question');
            var options = $(this).data('options');
            var answer = $(this).data('answer');
            var points = $(this).data('points');
            var question_imagen = $(this).data('question_imagen');
            
            $('input[name="selected_id"]').val(id);
            $('input[name="question"]').val(question);
            $('input[name="answer"]').val(answer);
            $('input[name="points"]').val(points);
            $('input[name="question_imagen"]').val(question_imagen);

            $('#set-options').html('');

            if(options.length>0){

                var anwersarr = answer.split('|')
                
                for (let index = 0; index < options.length; index++) {
                    const element = options[index];
                    console.log(element);
                    var ischecked = false;
                    if (anwersarr.includes(element)) {
                        ischecked = true;
                    }
                
                    putOption(index+1,element,ischecked);
                }
            }else{
                var ischecked = false;
                putOption(1,'',ischecked);
            }
            
            checkquestion_imagen();
            //putOption();
        });

        $(document).on('click','.deleoption',function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
            checkmaxinput();
            checkanswer();
        });

        $(document).on('click','.eliminar_imagen_question',function(e){
            e.preventDefault();
            $('.question_image_preview').html('');
            $('[name="question_imagen"]').val('');
        });

        $('#frm-create-question').on('submit',function(e){
            e.preventDefault();

            var data = $(this).serializeArray();
            console.log(data);

            $.ajax({
                type: "post",
                url: "{{route('practica.storequestion')}}",
                data:data,
                dateType:'json',
                success:function(data){
                    console.log(data);
                    $('[name="question_imagen"]').val('');
                    $('.question_image_preview').html('');
                    
                    $('[name="selected_id"]').val('');
                    $('[name="question"]').val('');
                    $('[name="answer"]').val('');
                    //$('[name="option[]"]').val('');

                    checkmaxinput();
                    

                    $('#sendbutton').html('Agregar pregunta');
                    getAllQuestions();
                },
                error:function(errordata){
                    console.log(errordata);
                    var serverResponse = JSON.parse(errordata.responseText);
                    
                    if(serverResponse.message=='Unauthenticated.'){
                        location.href="{{route('login')}}";
                    }
                }
            });
        });
       
    });
</script>
@endsection