<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticaController;
use App\Http\Controllers\RegistroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});

*/

Route::middleware(['auth:sanctum', 'verified'])->get('/', [PracticaController::class,'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/start',function () {
    return view('dashboard');
})->name('inicio');


Route::middleware(['auth:sanctum', 'verified'])->any('/practica',[PracticaController::class,'index'])->name('practica');

Route::middleware(['auth:sanctum', 'verified'])->get('/send',function () {
    return view('send');
})->name('send');

Route::get('/registrar',[RegistroController::class,'index'])->name('registrar');
Route::post('/registrar/store',[RegistroController::class,'store'])->name('registrar.store');


Route::middleware(['auth:sanctum', 'verified'])->any('/practica/editar/{id}',[PracticaController::class,'index'])->name('practica.editar');
Route::middleware(['auth:sanctum', 'verified'])->get('/practica/eliminar/{id}',[PracticaController::class,'eliminar'])->name('practica.eliminar');
Route::middleware(['auth:sanctum', 'verified'])->get('/practicax/get',[PracticaController::class,'get'])->name('practica.get');


Route::middleware(['auth:sanctum', 'verified'])->get('/practica/preguntas',[PracticaController::class,'preguntas'])->name('practica.preguntas');
Route::middleware(['auth:sanctum', 'verified'])->post('/practicax/responder',[PracticaController::class,'responder'])->name('practica.responder');
Route::middleware(['auth:sanctum', 'verified'])->get('/practica/responder/get',[PracticaController::class,'getanswer'])->name('practica.responder.get');
Route::middleware(['auth:sanctum', 'verified'])->get('/practica/responder/json',[PracticaController::class,'json'])->name('practica.responder.json');

Route::middleware(['auth:sanctum', 'verified'])->get('/practica/dropquest',[PracticaController::class,'dropquest'])->name('practica.dropquest');

Route::middleware(['auth:sanctum', 'verified'])->get('/practica/respuestas',[PracticaController::class,'respuestas'])->name('practica.respuestas');
Route::middleware(['auth:sanctum', 'verified'])->any('/practica/storequestion',[PracticaController::class,'storequestion'])->name('practica.storequestion');
Route::middleware(['auth:sanctum', 'verified'])->post('/practica/sendimagequestion',[PracticaController::class,'sendimagequestion'])->name('sendimagequestion');
Route::middleware(['auth:sanctum', 'verified'])->get('/practica/{id}',[PracticaController::class,'practica'])->name('practicar');

Route::middleware(['auth:sanctum', 'verified'])->get('/practica/{id}/{practica?}/{resuelto?}',[PracticaController::class,'practica2'])->name('practicar.accion');


Route::middleware(['auth:sanctum', 'verified'])->get('/practicar/getanswers',[PracticaController::class,'getanswers'])->name('practica.getanswers');
Route::middleware(['auth:sanctum', 'verified'])->get('/practicar/getstudents',[PracticaController::class,'getstudents'])->name('practica.getstudents');

Route::middleware(['auth:sanctum', 'verified'])->get('/practican/savemaximo',[PracticaController::class,'savemaximo'])->name('practica.savemaximo');
Route::middleware(['auth:sanctum', 'verified'])->get('/practican/saveq',[PracticaController::class,'saveq'])->name('practica.saveq');
