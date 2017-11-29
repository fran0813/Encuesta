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
	Route::get('/mostrarEncuestas', 'AdminController@mostrarEncuestas');
	Route::get('/encuesta', 'AdminController@encuesta');
	Route::get('/crearEncuesta', 'AdminController@crearEncuesta');
	Route::get('/crearEncuestas', 'AdminController@crearEncuestas');
	Route::get('/preguntas', 'AdminController@preguntas');
	Route::get('/mostrarPreguntas', 'AdminController@mostrarPreguntas');
	Route::get('/crearPreguntaAbierta', 'AdminController@crearPreguntaAbierta');
	Route::get('/crearPreguntaCerrada', 'AdminController@crearPreguntaCerrada');
	Route::get('/crearRespuestaCerrada', 'AdminController@crearRespuestaCerrada');
	Route::get('/mostrarRespuestasCerradas', 'AdminController@mostrarRespuestasCerradas');
	Route::post('/idEncuesta', 'AdminController@idEncuesta');
	Route::post('/idRespuestaCerrada', 'AdminController@idRespuestaCerrada');
	Route::post('/idAbierta', 'AdminController@idAbierta');
	Route::post('/idCerrada', 'AdminController@idCerrada');
	Route::get('/mostrarActualizarEncuesta', 'AdminController@mostrarActualizarEncuesta');
	Route::get('/editarEncuesta', 'AdminController@editarEncuesta');
	Route::get('/mostrarActualizarPregunta', 'AdminController@mostrarActualizarPregunta');
	Route::get('/mostrarActualizarRespuestaCerrada', 'AdminController@mostrarActualizarRespuestaCerrada');
	Route::get('/editarPreguntaAbierta', 'AdminController@editarPreguntaAbierta');
	Route::get('/editarPreguntaCerrada', 'AdminController@editarPreguntaCerrada');
	Route::get('/editarRespuestaCerrada', 'AdminController@editarRespuestaCerrada');
	Route::get('/verdadera', 'AdminController@verdadera');
	Route::get('/eliminarEncuesta', 'AdminController@eliminarEncuesta');
	Route::get('/eliminarPregunta', 'AdminController@eliminarPregunta');
	Route::get('/eliminarRespuestaCerrada', 'AdminController@eliminarRespuestaCerrada');
});

Route::group(['prefix' => 'user'], function(){
	Route::get('/', 'UserController@index')->middleware('auth');
});
