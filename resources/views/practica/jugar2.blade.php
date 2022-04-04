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
  
    .bg-box {
        max-width: 88% !important;
    }
    .bg-blue{
        background: #F2F7FD;
    }
    .box-center{
        padding-top: 30px;
    }
    .question-title{
        font-size: 19px;
        line-height: 25px;
        color: #0e5bc7;
        margin-bottom: 26px;
        font-weight: bold;
        text-transform: uppercase;
        font-family: Arial;
    }
    .alternative_button {
        -webkit-transition: border 0s;
        transition: border 0s;
        color: #252b2f;
        border: .125rem solid #fff;
        background-color: #fff;
        -webkit-box-shadow: 0 0.0625rem 0.1875rem 0 rgb(0 0 0 / 10%);
        box-shadow: 0 0.0625rem 0.1875rem 0 rgb(0 0 0 / 10%);
        width: 100%;
    margin-bottom: 0px;
    border-radius: 3px;
    cursor: pointer;
    padding: 8px 9px;
    margin-top: 16px;
    }
    .alternative_button:hover{
        
    }
    .alternative_button  span{
        font-size: 21px;
        padding: 10px 10px;
        margin: 0 auto;
        font-weight: 600;
    }
    .btn-send-b {
        background: #116EEE;
    border-radius: 54px;
    margin: 0 auto;
    display: inline-block;
    font-family: Arial;
    color: white;
    font-size: 17px;
    padding: 9px 29px !important;
    font-weight: 700;
}
.btn-send-b:hover {
    background: #2c84ff;
}
.panel-response{
    background: #fff;
    padding: 26px 30px;
}
.panel-response .respect-padding,.box-center{
    padding-left: 30px;
    padding-right: 30px;
}
.tiitle_correct_answer{
    font-weight: bold;
    font-size: 17px;
    color: #404040;
}
.checks{
    font-size: 25px;
    font-weight: 800;
}
.good .checks{
    color: #008A22;
}
.good span.bol,
.bad span.bol{
    display: inline-block;
    width: 40px;
    height: 40px;
    
    border-radius: 50%;
    overflow: hidden;
    text-align: center;
    line-height: 39px;
    margin-right: 16px;
}
.bad span.bol{
    background: #ff9d9d;
    fill: #e41b1b;
}
.good span.bol{
    background: #BFE2C8;
    fill: green;
}
.good span.bol svg,
.bad span.bol svg{
    display:inline-block;
    width: 16px;
    height: 16px;
}
.good .success-text{
    color: #008A22;
    font-weight: bold;
    font-size: 20px;
}
.bad .error-text{
    color: rgb(228, 27, 27);
    font-weight: bold;
    font-size: 20px;
}
.bad .checks{
    color: rgb(228, 27, 27);
}
.input-response{
    border-radius: 0;
    border: 0;
    font-family: Arial;
    font-size: 21px;
    text-transform: uppercase;
    line-height: 38px;
    background: transparent;
    border-bottom: 2px solid #A7B0B7;
    box-shadow: none;
    padding: 0px 31px;
    width: 100%;
    margin-top:20px;
}
.input-response:focus{
    border-bottom: 2px solid #0e5bc7;
}
audio{
    width: 100%
}
.selectedoption{
    background: #0e5bc7;
    color: white;
}
.content-answer{
    max-height: 90vh;
    overflow-y: auto;
}
.img_question{
    max-height: 353px;
    max-width: 495px;
    margin: 0 auto;
    border-radius: 12px;
    box-shadow: 0 0 8px 2px #ebeff5;
}
body .alternative_button span{
    padding: 0 !important;
}
body .flex-options>label{
    background: transparent;
    border: 0;
    box-shadow: none;
}
body .flex-options>label img{
    box-shadow: 0 0 3px 4px #eff1f3;
    border-radius: 11px;
}
.questions.box-center{
    overflow-y: auto;
    height: 90vh;
    padding-bottom: 73px;
}
@media(max-width:760px){
    .question .img_question{
        max-width: 90%;
    }
}
</style>
<div class="inset-0 fixed bg-blue z-50">
    <div class="max-w-4xl m-auto" style="overflow:auto">
        <div class="questions box-center">
            
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
                    $('.questions').html(data);
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
        var textbtn = 'Comprobar';

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
                    cssforflex = 'flex-options grid grid-cols-1 mt-4 md:grid-cols-3 gap-4';
                    questionst = '<img src="'+questionst+'" style="max-height: 200px; display: inline-block; margin: 0 auto;">';
                }

                textanswer += '<label class="inline-flex items-center alternative_button '+cssformgrid+' relative">';
                textanswer += '<input style="opacity:0" type="radio" '+strrequired+' class="form-radio" name="useranswer" value="'+questoption+'">';
                textanswer += '<span class="ml-2 notranslate text-2xl mr-4">';
                //textanswer += '<svg aria-hidden="true" class="this-check" focusable="false" data-prefix="fal" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-check-circle fa-w-16 fa-3x"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 464c-118.664 0-216-96.055-216-216 0-118.663 96.055-216 216-216 118.664 0 216 96.055 216 216 0 118.663-96.055 216-216 216zm141.63-274.961L217.15 376.071c-4.705 4.667-12.303 4.637-16.97-.068l-85.878-86.572c-4.667-4.705-4.637-12.303.068-16.97l8.52-8.451c4.705-4.667 12.303-4.637 16.97.068l68.976 69.533 163.441-162.13c4.705-4.667 12.303-4.637 16.97.068l8.451 8.52c4.668 4.705 4.637 12.303-.068 16.97z" class=""></path></svg>';
                    textanswer += questionst;
                textanswer += '</span>';
                textanswer += '</label>';
             
            }
                         
                
        }else{
            textanswer = '<input required autocomplete="off" type="text" autofocus name="useranswer" required  class="options input-response">'
        }

        if((questions.length-current_quest)==1){
            textbtn = 'Enviar practica';
        }
        var btn = '<button type="submit"   class="send-rr btn-send-b">'+textbtn+'</button>';

        question = '<form class="question '+cssform+'" data-question_id="'+dataquestion.id+'" data-points="'+dataquestion.points+'" data-answer="'+dataquestion.answer+'">';
        question += '<p class="notranslate question-title">'+(current_quest+1) + ') ' + dataquestion.question + '</p>';

        var str_img  = '';

        if(dataquestion.question_imagen!=null){
            var ext = dataquestion.question_imagen.split('.').pop();

            var link = "{{asset('material/questions') . '/'}}" + dataquestion.question_imagen;

            if(ext=='mp3'){
                str_img = '<audio controls autoplay><source src="'+link+'" type="audio/mpeg"></audio>';
            }else{
                str_img = '<img src="'+link+'" class="img_question" />';
            }
        }
        question += str_img;
        question += '<div class="'+cssforflex+'">' + textanswer + '</div>';

        var correct_answer_result = '<div class="good" style="display:none">';
        var iconcheck = '<span class="icon bol"><svg xmlns="http://www.w3.org/2000/svg" width="23px" height="23px" viewBox="0 0 46 46"> <path fill-rule="evenodd" d="M44.596 3.723L40.546.871a2.399 2.399 0 0 0-3.403.666l-19.85 30.33-9.123-9.45a2.386 2.386 0 0 0-3.459 0l-3.464 3.588c-.953.99-.953 2.596 0 3.593l14.024 14.536c.784.813 2.022 1.435 3.133 1.435 1.11 0 2.234-.722 2.953-1.81l23.89-36.52c.758-1.149.47-2.732-.651-3.516z"></path> </svg> </span>';
        var iconcheckb = '<span class="icon bol"><svg width="23px" height="23px" viewBox="0 0 120 120" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <defs></defs> <g id="Artboard" stroke-width="1" fill-rule="evenodd"> <path d="M95.3975981,16.7092532 C94.4507975,15.7635823 92.9157403,15.7635823 91.9689398,16.7092532 L61.7148883,46.9699486 C60.7680877,47.9156195 59.2330306,47.9156195 58.28623,46.9699486 L28.0310602,16.7092532 C27.0842597,15.7635823 25.5492025,15.7635823 24.6024019,16.7092532 L16.7095545,24.6028135 C15.7634818,25.5505349 15.7634818,27.0841609 16.7095545,28.0318824 L46.9658425,58.2847591 C47.9163838,59.2308247 47.9163838,60.7677624 46.9658425,61.713828 L16.7095545,91.9756404 C15.7634818,92.9233618 15.7634818,94.4569878 16.7095545,95.4047093 L24.6024019,103.290451 C25.5492025,104.236122 27.0842597,104.236122 28.0310602,103.290451 L58.28623,73.0364571 C58.7395785,72.5798506 59.3567356,72.3230103 60.0005591,72.3230103 C60.6443827,72.3230103 61.2615398,72.5798506 61.7148883,73.0364571 L91.9689398,103.290451 C92.919481,104.236516 94.4515299,104.236516 95.3975981,103.290451 L103.290446,95.4024753 C104.236518,94.4547539 104.236518,92.9211279 103.290446,91.9734064 L73.0363941,61.7160619 C72.0903214,60.7683404 72.0903214,59.2347145 73.0363941,58.286993 L103.290446,28.0318824 C104.236518,27.0841609 104.236518,25.5505349 103.290446,24.6028135 L95.3975981,16.7103702 L95.3975981,16.7092532 Z" id="Shape" fill-rule="nonzero"></path> </g> </svg> </span>';
            correct_answer_result+='<div class="flex items-center success-text">'+iconcheck+' Correcto</div></div>';

        var incorrect_answer_result = '<div class="bad" style="display:none"><p class="tiitle_correct_answer ">Respuesta correcta</p>';
        var arranswer = dataquestion.answer.split('|');
        for (let ca = 0; ca < arranswer.length; ca++) {
            const element = arranswer[ca];
            
            var is_img = element.split('.').pop();

            if(is_img=='png' || is_img=='jpg'){
                
                var linkr = element;

                incorrect_answer_result+='<p class="notranslate"><img src="'+linkr+'" style="max-height:50px" /></p>';
            }else{
                incorrect_answer_result+='<p class="notranslate">'+element+'</p>';
            }
        }
        incorrect_answer_result+='<p class="checks"><div class="flex items-center error-text">'+iconcheckb+' Incorrecto</div></p>';
        incorrect_answer_result+='</div>';
        
        question += '<div class="absolute bottom-0 left-0 right-0 w-full panel-response">';
        question += '<div class="grid grid-cols-1 md:grid-cols-2 gap-5 max-w-4xl m-auto respect-padding">';
        question += '<div class="results col-span-1">'+correct_answer_result+incorrect_answer_result+'</div><div class="col-span-1 text-right">' + btn + '</div></div>';
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
                        $('.good').show();
                    }else{
                       
                        $('.bad').show();
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
                //
                pregunta_respondida = true;
            }else{
                pregunta_respondida = false;
                doQuest();
            }

            

        });
        
       
    });
</script>
@endsection