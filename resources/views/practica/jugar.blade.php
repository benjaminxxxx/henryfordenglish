@extends('layouts.admin2')
@section('content')
@php
    $total_points = 0;
    $alp = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
@endphp
<audio controls id="correcto">
    <source src="{{asset('sounds/correct.mp3')}}" type="audio/mpeg">
  Your browser does not support the audio element.
  </audio>
<style>
    .question{
        min-height: 94px;
        background: #daffaf;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: inset 0 0 34px #baff66;
        border: 10px solid #fec149;
        padding: 13px 25px;
        width: 100%;
        font-family: 'Lilita One', cursive;
        font-size: 38px !important;
        text-transform: uppercase;
        color: #000000;
    }
    .bg-box {
        max-width: 88% !important;
    }
    @media(max-width:760px){
        .bg-box {
            max-width: 100% !important;
            padding: 3px;
        }
        .alternative {
            padding: 3px 6px;
        }
        .alternative span{
            display: inline-block
        }
        .alternative input[type="radio"]{
            position: absolute
        }
    }
</style>
<div class="inset-0 fixed bg-galaxy z-50  fadeShadow">
    <div class="w-full h-full flex items-center justify-center fadeInDown" style="overflow:auto">
        <div class="bg-box fadeIn first questions">
            
        </div>
    </div>
</div>

@endsection
@section('after')
<script>

    var current_quest = 0;
    var parse = '<?php echo addslashes(json_encode($stringquestions)); ?>';
    var questions = JSON.parse(parse);
    var totalPoints = 0;
    var answers = {};
    var resuelto = "{{$resuelto}}";

    function init(){
        //verificar si ya he respondido esto
        
        $.ajax({
            type: "get",
            url: "{{route('practica.responder.get')}}",
            data:{
                practica_id:"{{$practica_id}}",
            },
            success:function(data){
                
                if(data==''){
                    doQuest();
                }else{

                    
                    if(resuelto=='true'){
                        $('.questions').html(data);
                    }else{
                       
                       $.ajax({
                            type: "get",
                            url: "{{route('practica.responder.json')}}",
                            data:{
                                practica_id:"{{$practica_id}}"
                            },
                            dataType:'json',
                            success:function(data){
                                parse = data.stringquestions;
                                console.log(data);
                                current_quest = 0;
                                
                                questions = parse;
                                totalPoints = 0;
                                answers = {};
                                resuelto = 'true';
                                doQuest();
                            },
                            error: function(errordata){
                                console.log(errordata);
                            }
                        });
                    }
                    
                }
                
            },
            error:function(errordata){
                console.log(errordata);
                init();
                var serverResponse = JSON.parse(errordata.responseText);
                
                if(serverResponse.message=='Unauthenticated.'){
                    location.href="{{route('login')}}";
                }
            }
        });
        
    }
    function doQuest(){

        $('.questions').html('');

        
        console.log(questions[current_quest]);
        var dataquestion = questions[current_quest];
        var question = '';
        var textanswer = '';
        var textbtn = 'Siguiente pregunta';

        if(dataquestion==undefined){
            //finish
            var answersd = JSON.stringify(answers);
           
            $.ajax({
                type: "post",
                url: "{{route('practica.responder')}}",
                data:{
                    _token:"{{ csrf_token() }}",
                    practica_id:"{{$practica_id}}",
                    answers:answersd
                },
                dataType:'json',
                success:function(data){
                    init();
                    console.log(data);
                },
                error:function(errordata){
                    console.log(errordata);
                    var serverResponse = JSON.parse(errordata.responseText);
                    
                    if(serverResponse.message=='Unauthenticated.'){
                        location.href="{{route('login')}}";
                    }
                }
            });
            return;
        }

        var cssform = '';
        var cssformgrid = '';
        var cssforflex = '';

        if(dataquestion.options.length>1){
            //do options

            for (let index = 0; index < dataquestion.options.length; index++) {
                const questoption = dataquestion.options[index];
                var strrequired = '';
                if(index==0){
                    strrequired = 'required';
                }
                var searchimg = questoption.split('.').pop();
                var questionst = questoption;
                
                var arr_options = ["jpg","jpeg","png","gif"];

                if (arr_options.includes(searchimg)) {

                    cssform = 'hasimages';
                    cssformgrid = 'col-span-1';
                    cssforflex = 'flex-options grid grid-cols-1 md:grid-cols-3 gap-4';
                    questionst = '<img src="'+questionst+'" style="max-height: 200px; display: inline-block; margin: 0 auto;">';
                }

                textanswer += '<label class="inline-flex items-center alternative '+cssformgrid+' relative">';
                textanswer += '<input style="opacity:0" type="radio" '+strrequired+' class="form-radio" name="useranswer" value="'+questoption+'">';
                textanswer += '<span class="ml-2 notranslate text-2xl mr-4">';
                textanswer += '<svg aria-hidden="true" class="this-check" focusable="false" data-prefix="fal" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 464c-118.664 0-216-96.055-216-216 0-118.663 96.055-216 216-216 118.664 0 216 96.055 216 216 0 118.663-96.055 216-216 216zm141.63-274.961L217.15 376.071c-4.705 4.667-12.303 4.637-16.97-.068l-85.878-86.572c-4.667-4.705-4.637-12.303.068-16.97l8.52-8.451c4.705-4.667 12.303-4.637 16.97.068l68.976 69.533 163.441-162.13c4.705-4.667 12.303-4.637 16.97.068l8.451 8.52c4.668 4.705 4.637 12.303-.068 16.97z" class=""></path></svg>';
                    textanswer += questionst;
                textanswer += '</span>';
                textanswer += '</label>';
             
            }
                         
                
        }else{
            textanswer = '<input required autocomplete="off" type="text" autofocus name="useranswer" required  class="w-full mt-3 options shadow text-response py-2 px-4 mt-2">'
        }

        if((questions.length-current_quest)==1){
            textbtn = 'Enviar practica';
        }
        var btn = '<button type="submit"   class="send-rr btn-send-a">'+textbtn+'</button>';

        question = '<form class="question relative '+cssform+'" data-question_id="'+dataquestion.id+'" data-points="'+dataquestion.points+'" data-answer="'+dataquestion.answer+'">';
            var linkinicio = "{{route('dashboard')}}";
            question += '<div class="relative md:absolute right-0 p-2 text-sm text-center bg-red-400 text-white rounded mr-2"><a href="'+linkinicio+'">Inicio</a></div>';
            question += '<p class="notranslate text-2xl md:text-4xl ">' + dataquestion.question + '</p>';

        var str_img  = '';

        if(dataquestion.question_imagen!=null){
            var ext = dataquestion.question_imagen.split('.').pop();

            var link = "{{asset('material/questions') . '/'}}" + dataquestion.question_imagen;

            if(ext=='mp3'){
                str_img = '<audio controls autoplay><source src="'+link+'" type="audio/mpeg"></audio>';
            }else{
                str_img = '<img src="'+link+'" style="max-height:200px" />';
            }
        }
        question += str_img;
        question += '<div class="'+cssforflex+'">' + textanswer + '</div>';
        question += btn;
        question += '</form>';
        $('.questions').html(question);
        $('[name="useranswer"]').focus();
    }

    jQuery(document).ready(function($){
       
        
        init();
        $(document).on('change','[class="form-radio"]',function(){
            $('[class="form-radio"]').parent('label').removeClass('selectedoption');
            if($(this).is(':checked')){
                $(this).parent('label').addClass('selectedoption');
            }
        });
        $(document).on('click','.ver-solucion',function(e){
            e.preventDefault();
            $('.to-center').removeClass('to-center');
            $(this).remove();
        });

        $(document).on('click','#try',function(e){
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "{{route('practica.responder.json')}}",
                data:{
                    practica_id:"{{$practica_id}}"
                },
                dataType:'json',
                success:function(data){
                    parse = data.stringquestions;
                    console.log(data);
                    current_quest = 0;
                    
                    questions = parse;
                    totalPoints = 0;
                    answers = {};
                    doQuest();
                },
                error: function(errordata){
                    console.log(errordata);
                }
            });
        });

        var pregunta_respondida = false;
        $(document).on('change','input[type=radio]',function(e){
            e.preventDefault();
            $(this).closest("form").submit();
        });

        $(document).on('submit','.question',function(e){
            e.preventDefault();
            
            if(pregunta_respondida==false){

                var points = $(this).data('points');
                var answer = $(this).data('answer');
                var question_id = $(this).data('question_id');
                var unitpoint = 0;
                var myanswer = '';

                var type = $('[name="useranswer"]').attr('type');
                if(type=='text'){
                    myanswer = $('[name="useranswer"]').val().toUpperCase();
                }
                if(type=='radio'){
                    myanswer = $('[name="useranswer"]:checked').val().toUpperCase();
                }

                var myanswerfake = myanswer.replace(/[.,'?\/#!$%\^&\*;:{}=\-_`~()]/g,"");
                myanswerfake = myanswerfake.replace(/\s{2,}/g," ");
                myanswerfake = myanswerfake.replace(/\s/g,'');
                
                if(answer!=null){
                    answer = String(answer);
                    console.log(answer);
                    console.log(typeof answer);
                    var upperanswer = answer.toUpperCase();
                    upperanswer = upperanswer.replace(/[.,'?\/#!$%\^&\*;:{}=\-_`~()]/g,"");
                    upperanswer = upperanswer.replace(/\s{2,}/g," ");
                    upperanswer = upperanswer.replace(/\s/g,'');
                    console.log('cadena de opciones: ' + upperanswer);
                    var arr_answers = upperanswer.split('|');
                    console.log(arr_answers);
                    if (arr_answers.includes(myanswerfake)) {
                        if(points!=null){
                            totalPoints+=points;
                            unitpoint = points;
                        }
                        
                        document.getElementById('correcto').play();
                    }
                    
                    /*
                    if(answer.toUpperCase()==myanswer){
                        if(points!=null){
                            totalPoints+=points;
                            unitpoint = points;
                        }
                    }*/
                }

                answers[current_quest] = {
                    points:unitpoint,
                    answer:myanswer,
                    question_id:question_id
                };
                
                current_quest++;
                pregunta_respondida = true;
            }else{
                pregunta_respondida = false;
                doQuest();
            }

        });
        
       
    });
</script>
@endsection