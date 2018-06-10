<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function(){
	Route::get('/', 'AdminController@index')->middleware('auth');
	Route::get('/encuesta', 'AdminController@encuesta');
	Route::get('/preguntas', 'AdminController@preguntas');
	Route::get('/responder', 'AdminController@responder');
	Route::get('/responderEncuesta', 'AdminController@responderEncuesta');
	Route::get('/tabulacion', 'AdminController@tabulacion');
	Route::get('/graficas', 'AdminController@graficas');

	Route::get('/crearEncuesta', 'AdminController@crearEncuesta');
	Route::get('/crearEncuestas', 'AdminController@crearEncuestas');
	Route::get('/crearPreguntaAbierta', 'AdminController@crearPreguntaAbierta');
	Route::get('/crearPreguntaCerrada', 'AdminController@crearPreguntaCerrada');
	Route::get('/crearRespuestaCerrada', 'AdminController@crearRespuestaCerrada');

	Route::post('/responderPreguntas', 'AdminController@responderPreguntas');
	
	Route::get('/mostrarEncuestas', 'AdminController@mostrarEncuestas');
	Route::get('/mostrarPreguntas', 'AdminController@mostrarPreguntas');
	Route::get('/mostrarRespuestasCerradas', 'AdminController@mostrarRespuestasCerradas');
	Route::get('/mostrarEncuestasResponder', 'AdminController@mostrarEncuestasResponder');
	Route::get('/mostrarPreguntasResponder', 'AdminController@mostrarPreguntasResponder');
	Route::get('/mostrarTabulaciones', 'AdminController@mostrarTabulaciones');
	Route::get('/mostrarGraficas', 'AdminController@mostrarGraficas');
	Route::get('/mostrarG', 'AdminController@mostrarG');

	Route::get('/mostrarActualizarEncuesta', 'AdminController@mostrarActualizarEncuesta');
	Route::get('/mostrarActualizarPregunta', 'AdminController@mostrarActualizarPregunta');
	Route::get('/mostrarActualizarRespuestaCerrada', 'AdminController@mostrarActualizarRespuestaCerrada');
	
	Route::get('/editarEncuesta', 'AdminController@editarEncuesta');
	Route::get('/editarPreguntaAbierta', 'AdminController@editarPreguntaAbierta');
	Route::get('/editarPreguntaCerrada', 'AdminController@editarPreguntaCerrada');
	Route::get('/editarRespuestaCerrada', 'AdminController@editarRespuestaCerrada');

	Route::post('/idEncuesta', 'AdminController@idEncuesta');
	Route::post('/idRespuestaCerrada', 'AdminController@idRespuestaCerrada');
	Route::post('/idAbierta', 'AdminController@idAbierta');
	Route::post('/idCerrada', 'AdminController@idCerrada');
	
	Route::get('/verdadera', 'AdminController@verdadera');
	Route::post('/verificar1', 'AdminController@verificar1');

	Route::get('/eliminarEncuesta', 'AdminController@eliminarEncuesta');
	Route::get('/eliminarPregunta', 'AdminController@eliminarPregunta');
	Route::get('/eliminarRespuestaCerrada', 'AdminController@eliminarRespuestaCerrada');
});

Route::group(['prefix' => 'user'], function(){
	Route::get('/', 'UserController@index')->middleware('auth');
});
