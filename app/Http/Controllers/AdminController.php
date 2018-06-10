<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Response;
use App\Encuesta;
use App\Pregunta;
use App\Abierta;
use App\Cerrada;
use App\RespuestaCerrada;
use App\ResponderEncuesta;
use App\Respuesta;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    // Redireccionar a crear la preguntas
    public function preguntas(){
        return view('admin.preguntas');
    }

    // Redireccionar a la encuesta
    public function encuesta(Request $request){
        return view('admin.encuesta');
    }

    // Redireccionar a crear la encuesta
    public function crearEncuesta(Request $request){
        return view('admin.crearEncuesta');
    }

    // Redireccionar a seleccionar encuesta a responder
    public function responder(Request $request){
        return view('admin.responder');
    }

    // Redireccionar a responder encuesta
    public function responderEncuesta(Request $request){
        return view('admin.responderEncuesta');
    }

    // Redireccionar a tabulacion
    public function tabulacion(){
        return view('admin.tabulacion');
    }

     // Redireccionar a graficas
    public function graficas(){
        return view('admin.graficas');
    }


    // Establece el id de la encuesta
    public function idEncuesta(Request $request)
    {
        $tipo = $_POST['tipo'];

        if($tipo == "crear"){
            $idEncuestas = Encuesta::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();
            foreach ($idEncuestas as $idEncuesta) {
                $id = $idEncuesta->id;          
            };

            $request->session()->put("idEncuesta",$id);            

        }else if($tipo == "editar"){
            $id = $_POST['idEncuesta'];

            $request->session()->put("idEncuesta",$id);
        }
        
        return Response::json(array('html' => "ok"));
    }

    // Establece el id de la encuesta cuando se crea
    public function idAbierta(Request $request){

        $id = $_POST['id'];

        $results = Abierta::where('pregunta_id', $id)->get();

        foreach ($results as $result) {
            $id = $result->id;
        }

        $request->session()->put("idAbierta",$id);

        return Response::json(array('html' => "ok"));
    }

    // Establece el id de la encuesta cuando se crea
    public function idCerrada(Request $request){

        $id = $_POST['id'];

        if($id == "crear"){

            $id = "";
            $idPreguntas = Cerrada::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idPreguntas as $idPregunta) {
                $id = $idPregunta->id;          
            };

            $request->session()->put("idCerrada",$id);
        }else{

            $results = Cerrada::where('pregunta_id', $id)->get();

            foreach ($results as $result) {
                $id = $result->id;
            }

            $request->session()->put("idCerrada",$id);

        }

        return Response::json(array('html' => $id));
    }

    // Establece el id de la pregunta cuando se crea
    public function idRespuestaCerrada(Request $request){

        $id = $_POST['id'];

        $request->session()->put("idRespuestaCerrada",$id);

        return Response::json(array('html' => "ok"));
    }


    // Crea la encuesta
    public function crearEncuestas(Request $request){
        
        $boolean = False;
        $html = "";

        $titulo = $_GET['titulo'];
        $descripcion = $_GET['descripcion'];

        $verificarEncuestas = Encuesta::where('titulo', $titulo)->get();

        foreach ($verificarEncuestas as $verificarEncuesta) {
            $boolean = True;         
        };
                                    
        if($boolean == False){
            $encuesta = new Encuesta;
            $encuesta->titulo = $titulo;
            $encuesta->descripcion = $descripcion;
            $encuesta->user_id = Auth::user()->id;
            $encuesta->save();

            $html = "<p>Se ha creado la encuesta con éxito</p>";
        }else{
            $html = "<p>La encuesta ya existe</p>";            
        }

        return Response::json(array('html' => $html,));
    }

    // Crea la pregunta bierta
    public function crearPreguntaAbierta(Request $request)
    {
        $preguntaRecibida = $_GET['preguntaAbierta'];
        $boolean = False;
        $html = "";

        $idEncuesta = null;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $verificarPreguntaAbiertas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('abiertas', 'preguntas.id', 'abiertas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'abiertas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('abiertas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaAbiertas as $verificarPreguntaAbierta) {
            $boolean = True;
        };

        $verificarPreguntaCerradas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('cerradas', 'preguntas.id', 'cerradas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'cerradas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('cerradas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaCerradas as $verificarPreguntaCerrada) {
            $boolean = True;         
        };
                                    
        if($boolean == False){

            $pregunta = new Pregunta;
            $pregunta->encuesta_id = $idEncuesta;
            $pregunta->save();

            $idPreguntas = Pregunta::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idPreguntas as $idPregunta) {
                $idPregunta = $idPregunta->id;
            }

            $preguntaAbierta = new Abierta;
            $preguntaAbierta->pregunta = $preguntaRecibida;
            $preguntaAbierta->pregunta_id = $idPregunta;
            $preguntaAbierta->save();

            $html = "<p>Se ha creado la pregunta con éxito</p>";
        }else{
            $html = "<p>La pregunta ya existe</p>";            
        }

        return Response::json(array('html' => $html,));
    }

    // Crea la pregunta cerrada
    public function crearPreguntaCerrada(Request $request)
    {
        $boolean = False;
        $html = "";
        $preguntaCerradaBoolean = True;

        $idEncuesta = null;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntaRecibida = $_GET['preguntaCerrada'];

        $verificarPreguntaAbiertas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('abiertas', 'preguntas.id', 'abiertas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'abiertas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('abiertas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaAbiertas as $verificarPreguntaAbierta) {
            $boolean = True;         
        };

        $verificarPreguntaCerradas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('cerradas', 'preguntas.id', 'cerradas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'cerradas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('cerradas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaCerradas as $verificarPreguntaCerrada) {
            $boolean = True;         
        };
                                    
        if($boolean == False){

            $pregunta = new Pregunta;
            $pregunta->encuesta_id = $idEncuesta;
            $pregunta->save();

            $idPreguntas = Pregunta::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idPreguntas as $idPregunta) {
                $idPregunta = $idPregunta->id;
            }

            $correcta = " ";
            $preguntaCerrada = new Cerrada;
            $preguntaCerrada->pregunta = $preguntaRecibida;
            $preguntaCerrada->correcta = $correcta;
            $preguntaCerrada->pregunta_id = $idPregunta;
            $preguntaCerrada->save();

            $preguntaCerradaBoolean = True;
            $html = "<p>Se ha creado la pregunta con éxito</p>";
        }else{
            $preguntaCerradaBoolean = False;
            $html = "<p>La pregunta ya existe</p>";            
        }

        return Response::json(array('html' => $html, 'verificar' => $preguntaCerradaBoolean));
    }

    // Crea la respuesta cerrada
    public function crearRespuestaCerrada(Request $request)
    {
        $boolean = False;
        $html = "";
        $idPregunta = null;
        $respuestaRecibida = $_GET['respuestaPregunta'];

        if($request->session()->get("idCerrada")){
            $idPregunta = $request->session()->get("idCerrada");
        }

        $verificarRespuestasCerradas = Cerrada::join('respuesta_cerradas', 'cerradas.id', 'respuesta_cerradas.cerrada_id')
                                        ->select('cerradas.*', 'respuesta_cerradas.*')
                                        ->where('cerradas.id', $idPregunta)
                                        ->where('respuesta_cerradas.respuesta', $respuestaRecibida)
                                        ->get();

        foreach ($verificarRespuestasCerradas as $verificarRespuestasCerrada) {
            $boolean = True;         
        };
                                    
        if($boolean == False){

            $tipo = $_GET['tipo'];

            if($tipo == "editar"){
                if($request->session()->get("idCerrada")){
                    $idPregunta = $request->session()->get("idCerrada");
                }
            }else{
                $idPreguntas = Cerrada::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

                foreach ($idPreguntas as $idPregunta) {
                    $idPregunta = $idPregunta->id;
                }
            }


            $respuestaCerrada = new RespuestaCerrada;
            $respuestaCerrada->respuesta = $respuestaRecibida;
            $respuestaCerrada->cerrada_id = $idPregunta;
            $respuestaCerrada->save();

            $html = "<p>Se ha creado la pregunta con éxito</p>";
        }else{
            $html = "<p>La pregunta ya existe</p>";            
        }

        return Response::json(array('html' => $html));
    }

    public function mostrarActualizarEncuesta(Request $request)
    {
        $id = $_GET['id'];

        $Encuestas = Encuesta::where('id', $id)->get();

        foreach ($Encuestas as $Encuesta) {
           $titulo = $Encuesta->titulo;
           $descripcion = $Encuesta->descripcion;
        }

        return Response::json(array('titulo' => $titulo, 'descripcion' => $descripcion));
    }

    public function editarEncuesta(Request $request)
    {
        $titulo = $_GET['titulo'];
        $descripcion = $_GET['descripcion'];

        $html = "";

        $idEncuesta = null;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $encuesta = Encuesta::find($idEncuesta);

        $encuesta->titulo = $titulo;
        $encuesta->descripcion = $descripcion;

        $encuesta->save();

        $html = "Se actualizo la encuesta correctamente";

        return Response::json(array('html' => $html,));
    }

    public function mostrarActualizarPregunta(Request $request)
    {
        $id = $_GET['id'];
        $html = "";
        $boolean = "";

        $cerradas = Cerrada::where('pregunta_id', $id)->get();

        foreach ($cerradas as $cerrada) {
            $boolean = "cerrada";
            $idCerrada = $cerrada->id;
            $correcta = $cerrada->correcta;
            $pregunta = $cerrada->pregunta;
        }

        $abiertas = Abierta::where('pregunta_id', $id)->get();

        foreach ($abiertas as $abierta) {
            $boolean = "abierta";
            $idAbierta = $abierta->id;
            $pregunta = $abierta->pregunta;
        }

        if($boolean == "cerrada"){
            return Response::json(array('idCerrada' => $idCerrada, 'pregunta' => $pregunta, 'correcta'=> "La respuesta verdadera es: ".$correcta, 'tipo' => $boolean));
        }else if($boolean == "abierta"){
            return Response::json(array('pregunta' => $pregunta, 'tipo' => $boolean));
        }
    }

    public function editarPreguntaAbierta(Request $request)
    {
        $id = null;

        if($request->session()->get("idAbierta") ){
            $id = $request->session()->get("idAbierta");
        }

        $pregunta = $_GET['preguntaAbierta'];

        $html = "";

        $abierta = Abierta::find($id);

        $abierta->pregunta = $pregunta;

        $abierta->save();

        $html = "Se actualizo la pregunta correctamente";

        return Response::json(array('html' => $html,));
    }

    public function mostrarActualizarRespuestaCerrada(Request $request)
    {
        $id = $_GET['id'];

        $results = RespuestaCerrada::where('id', $id)->get();

        foreach ($results as $result) {
           $id = $result->id;
           $respuesta = $result->respuesta;
        }

        return Response::json(array('respuesta' => $respuesta));
    }

    public function editarPreguntaCerrada(Request $request)
    {
        $id = null;

        if($request->session()->get("idCerrada") ){
            $id = $request->session()->get("idCerrada");
        }

        $pregunta = $_GET['preguntaCerrada'];

        $html = "";

        $preguntaCerrada = Cerrada::find($id);

        $preguntaCerrada->pregunta = $pregunta;

        $preguntaCerrada->save();

        $html = "Se actualizo la pregunta correctamente";

        return Response::json(array('html' => $html,));
    }

    public function editarRespuestaCerrada(Request $request)
    {
        $id = null;

        $respuesta = $_GET['respuestaCerrada'];

        if($request->session()->get("idRespuestaCerrada") ){
            $id = $request->session()->get("idRespuestaCerrada");
        }        

        $html = "";

        $respuestaCerrada = RespuestaCerrada::find($id);

        $respuestaCerrada->respuesta = $respuesta;

        $respuestaCerrada->save();

        $html = "Se actualizo la pregunta correctamente";

        return Response::json(array('html' => $html,));
    }

    public function verdadera(Request $request)
    {
        $id = $_GET['id'];

        if($request->session()->get("idCerrada")){
            $idCerrada = $request->session()->get("idCerrada");
        }

        $results = RespuestaCerrada::where('id', $id)->get();

        foreach ($results as $result) {
            $respuesta = $result->respuesta;
            $id = $result->cerrada_id;
        }

        $verdadera = Cerrada::find($idCerrada);

        $verdadera->correcta = $respuesta;

        $verdadera->save();

        return Response::json(array('html' => "La respuesta verdadera es: ".$respuesta,));
    }

    public function eliminarEncuesta(Request $request)
    {
        $idEncuesta = $_GET['id'];

        $preguntas = Pregunta::where('encuesta_id', $idEncuesta)->get();

        foreach ($preguntas as $pregunta) {
            $idPregunta = $pregunta->id;

            $abiertas = Abierta::where('pregunta_id', $idPregunta)->get();

            foreach ($abiertas as $abierta) {
                $idAbierta = $abierta->id;

                $abierta = Abierta::find($idAbierta);

                $abierta->delete();
            }

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)->get();

            foreach ($cerradas as $cerrada) {
                $idCerrada = $cerrada->id;

                $respuestaCerradas = RespuestaCerrada::where('cerrada_id', $idCerrada)->get();

                foreach ($respuestaCerradas as $respuestaCerrada) {
                    $idRespuestaCerrada = $respuestaCerrada->id;

                    $respuestaCerrada = RespuestaCerrada::find($idRespuestaCerrada);

                    $respuestaCerrada->delete();
                }

                $cerrada = Cerrada::find($idCerrada);

                $cerrada->delete();                
            }

            $pregunta = Pregunta::find($idPregunta);

            $pregunta->delete();   
        }

        $encuesta = Encuesta::find($idEncuesta);

        $encuesta->delete(); 

        return Response::json(array('msg' => "ok",));
    }

    public function eliminarPregunta(Request $request)
    {
        $idPregunta = $_GET['id'];

        $abiertas = Abierta::where('pregunta_id', $idPregunta)->get();

        foreach ($abiertas as $abierta) {
            $idAbierta = $abierta->id;

            $abierta = Abierta::find($idAbierta);

            $abierta->delete();
        }

        $cerradas = Cerrada::where('pregunta_id', $idPregunta)->get();

        foreach ($cerradas as $cerrada) {
            $idCerrada = $cerrada->id;

            $respuestaCerradas = RespuestaCerrada::where('cerrada_id', $idCerrada)->get();

            foreach ($respuestaCerradas as $respuestaCerrada) {
                $idRespuestaCerrada = $respuestaCerrada->id;

                $respuestaCerrada = RespuestaCerrada::find($idRespuestaCerrada);

                $respuestaCerrada->delete();
            }

            $cerrada = Cerrada::find($idCerrada);

            $cerrada->delete();                
        }

        $pregunta = Pregunta::find($idPregunta);

        $pregunta->delete();   

        return Response::json(array('msg' => "ok",));
    }

    public function eliminarRespuestaCerrada(Request $request)
    {
        $idRespuestaCerrada = $_GET['id'];

        $respuestaCerrada = RespuestaCerrada::find($idRespuestaCerrada);

        $respuestaCerrada->delete();
        

        return Response::json(array('msg' => "ok",));
    }

    // Muestra las encuestas
    public function mostrarEncuestas(Request $request){

        $encuestas = Encuesta::all();

        $cont = 0;
        $html = "";
        $html .= "<table class='table table-bordered'>
                <thead class='thead-s'>
                <tr>";

        $html .= "<th>N°</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Funciones</th>";

        $html .= "</tr>
                </thead>
                <tbody>";

        foreach ($encuestas as $encuesta) {

            $id = $encuesta->id;
            $titulo = $encuesta->titulo;
            $descripcion = $encuesta->descripcion;
            $cont++;

            $html .="<tr class='border-dotted'>";

            $html .= "<td>$cont</td>";
            $html .= "<td>$titulo</td>";
            $html .= "<td>$descripcion</td>";
            $html .= "<td><a id='$id' href='#' class='btn btn-success' data-toggle='modal' data-target='#modalEditarEncuesta'>Editar</a><a id='$id' href='#' class='btn btn-danger'>Borrar</a></td>";

            $html .= "</tr>";           
        };

        $html .= "</tbody>
                </table>";

        return Response::json(array('html' => $html,));

    }

    // Muestra las preguntas
    public function mostrarPreguntas(Request $request){

        $idEncuesta = null;

        if($request->session()->get("idEncuesta") ){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $encuestas = Encuesta::where('id', $idEncuesta)->get();

        foreach ($encuestas as $encuesta) {
            $titulo = $encuesta->titulo;
        }

        $cont = 0;
        $html = "";
        $html .= "<table class='table table-bordered'>
                <thead class='thead-s'>
                <tr>";

        $html .= "<th>N°</th>
                <th>Pregunta</th>
                <th>Tipo</th>
                <th>Funciones</th>";

        $html .= "</tr>
                </thead>
                <tbody>";

        $preguntas = Pregunta::where('encuesta_id', $idEncuesta)->get();

        foreach ($preguntas as $pregunta) {
            $cont++;

            $idPregunta = $pregunta->id;

            $abiertas = Abierta::where('pregunta_id', $idPregunta)->get();

            foreach ($abiertas as $abierta) {

                $id = $abierta->id;
                $preguntaAbierta = $abierta->pregunta;

                $html .="<tr class='border-dotted'>";

                $html .= "<td>$cont</td>";
                $html .= "<td>$preguntaAbierta</td>";
                $html .= "<td>Abierta</td>";

                $html .= "<td><a id='$idPregunta' href='#' class='btn btn-success' data-toggle='modal' data-target='#modalEditarPreguntaAbierta'>Editar</a><a id='$idPregunta' href='#' class='btn btn-danger'>Borrar</a></td>";

                $html .= "</tr>"; 
            }

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)->get();

            foreach ($cerradas as $cerrada) {
                
                $id = $cerrada->id;
                $preguntaCerrada = $cerrada->pregunta;

                $html .="<tr class='border-dotted'>";

                $html .= "<td>$cont</td>";
                $html .= "<td>$preguntaCerrada</td>";
                $html .= "<td>Cerrada</td>";

                $html .= "<td><a id='$idPregunta' href='#' class='btn btn-success' data-toggle='modal' data-target='#modalEditarPreguntaCerrada'>Editar</a><a id='$idPregunta' href='#' class='btn btn-danger'>Borrar</a></td>";

                $html .= "</tr>"; 
            }
        }

        $html .= "</tbody>
                </table>";

        return Response::json(array('html' => $html, 'titulo' => $titulo));

    }

    // Muestra las tablas de respuestas cerradas
    public function mostrarRespuestasCerradas(Request $request){
        
        $idRespuestaCerrada = null;

        if($request->session()->get("idCerrada") ){
            $idCerrada = $request->session()->get("idCerrada");
        }        

        $respuestasCerradas = RespuestaCerrada::where('cerrada_id', $idCerrada)->get();              

        $cont = 0;
        $html = "";
        $html .= "<table class='table table-bordered'>
                <thead class='thead-s'>
                <tr>";

        $html .= "<th>N°</th>
                <th>Respuesta</th>
                <th>Funciones</th>";

        $html .= "</tr>
                </thead>
                <tbody>";

        foreach ($respuestasCerradas as $respuestasCerrada) {
            $cont++;
            $id = $respuestasCerrada->id;
            $respuesta = $respuestasCerrada->respuesta;

            $html .="<tr class='border-dotted'>";

            $html .= "<td>$cont</td>";
            $html .= "<td>$respuesta</td>";

            $html .= "<td><a id='$id' href='#' class='btn btn-success' data-toggle='modal' data-target='#modalEditarRespuestaCerrada'>Editar</a><a id='$id' href='#' class='btn btn-danger'>Borrar</a><a id='$id' href='#' class='btn btn-info'>Verdadera</a></td>";

            $html .= "</tr>"; 
        }

        $html .= "</tbody>
                </table>";

        return Response::json(array('html' => $html,));

    }

    // Muestra las encuestas
    public function mostrarEncuestasResponder(Request $request){

        $encuestas = Encuesta::all();
        $boolean = False;

        $cont = 0;
        $html = "";
        $html .= "<table class='table table-bordered'>
                <thead class='thead-s'>
                <tr>";

        $html .= "<th>N°</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Funciones</th>";

        $html .= "</tr>
                </thead>
                <tbody>";

        $idUser = Auth::user()->id;
        $boolean = False;        

        foreach ($encuestas as $encuesta) {

            $id = $encuesta->id;
            $titulo = $encuesta->titulo;
            $descripcion = $encuesta->descripcion;
            $cont++;

            $html .="<tr class='border-dotted'>";

            $html .= "<td>$cont</td>";
            $html .= "<td>$titulo</td>";
            $html .= "<td>$descripcion</td>";

            $verificar = ResponderEncuesta::where('user_id', $idUser)
                                        ->where('encuesta_id', $id)
                                        ->get();
            foreach ($verificar as $verifica) {
                $boolean = True;
            }

            if ($boolean == True) {
                $html .= "<td><a id='$id' href='#' class='btn btn-danger' value='responder'>Responder</a></td>";
            } else {
                $html .= "<td><a id='$id' href='#' class='btn btn-success' value='responder'>Responder</a></td>";
            }
            $html .= "</tr>";           
        };

        $html .= "</tbody>
                </table>";

        return Response::json(array('html' => $html,));

    }

    // Muestra las tablas de respuestas cerradas
    public function mostrarPreguntasResponder(Request $request)
    {
        $html = "";
        $idEncuesta = null;
        $boolean = False;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                ->select('preguntas.id')
                                ->where('encuestas.id', $idEncuesta)
                                ->where('preguntas.encuesta_id', $idEncuesta)
                                ->get();
        foreach ($preguntas as $pregunta) {
            $boolean = True;
            $idPregunta = $pregunta->id;

            $abiertas = Abierta::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($abiertas as $abierta) {
                $preguntaA = $abierta->pregunta;

                $html .= "<h4>Pregunta: $preguntaA</h4>";  
                $html .= "<input type='text' class='form-control' placeholder='Respuesta' name='$preguntaA' required>";  
                 
            }

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($cerradas as $cerrada) {
                $preguntaC = $cerrada->pregunta;
                
                $html .= "<h4>Pregunta: $preguntaC</h4>";   
            }                 


            $cerrada_respuestas = Cerrada::join('respuesta_cerradas', 'cerradas.id', 'respuesta_cerradas.cerrada_id')
                                ->where('cerradas.pregunta_id', $idPregunta)
                                ->get();  

            foreach ($cerrada_respuestas as $cerrada_respuesta) {
                $respuesta = $cerrada_respuesta->respuesta;

                $html .= "<input type='radio' name='$preguntaC' value='$respuesta' required>$respuesta<br>";
            }      

            $html .= "<br>";           
     
        }

        if ($boolean == True) {
            $html .= "<button type='submit' class='btn btn-success'>Aceptar</button>";
        }        

        return Response::json(array('html' => $html,));
    }

    // Responder las preguntas
    public function responderPreguntas(Request $request)
    {
        $idEncuesta = null;
        $boolean = False;
        $booleanA = False;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $responder_encuestas = new ResponderEncuesta;
        $responder_encuestas->user_id = Auth::user()->id;
        $responder_encuestas->encuesta_id = $idEncuesta;
        $responder_encuestas->save();

        $idResponder_encuestas = responderEncuesta::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();
        foreach ($idResponder_encuestas as $idResponder_encuesta) {
            $id = $idResponder_encuesta->id;          
        };

        $preguntas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                ->select('preguntas.id')
                                ->where('encuestas.id', $idEncuesta)
                                ->where('preguntas.encuesta_id', $idEncuesta)
                                ->get();
        foreach ($preguntas as $pregunta) {
            $boolean = True;
            $idPregunta = $pregunta->id;

            $abiertas = Abierta::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($abiertas as $abierta) {
                $preguntaA = $abierta->pregunta;
                $booleanA = True;
                 
            }

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($cerradas as $cerrada) {
                $preguntaC = $cerrada->pregunta;
                $booleanA = False;
            }                 


            $cerrada_respuestas = Cerrada::join('respuesta_cerradas', 'cerradas.id', 'respuesta_cerradas.cerrada_id')
                                ->where('cerradas.pregunta_id', $idPregunta)
                                ->get();  

            foreach ($cerrada_respuestas as $cerrada_respuesta) {
                $respuesta = $cerrada_respuesta->respuesta;
            }      

            $respuesta = new Respuesta;         
            $respuesta->pregunta_id = $idPregunta;
            if ($booleanA == True) {
                $respuesta->respuesta = $request->input($preguntaA); 
                $respuesta->tipo = "abierta";    
            }else{
                $respuesta->respuesta = $request->input($preguntaC);
                $respuesta->tipo = "cerrada"; 
            }                           
            $respuesta->realizarEncuesta_id = $id;               
            $respuesta->save();       
     
        }

        if($boolean == True){
            return redirect('/admin/responder');
        }else{
            return redirect('/admin/responderEncuesta');
        }
    }

    //Validar 1
    public function verificar1(Request $request)
    {
        $idUser = Auth::user()->id;
        $idEncuesta = null;
        $boolean = False;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $verificar = ResponderEncuesta::where('user_id', $idUser)
                                        ->where('encuesta_id', $idEncuesta)
                                        ->get();
        foreach ($verificar as $verifica) {
            $boolean = True;
        }

        return Response::json(array('html' => $boolean));
    }

    // Muestra las tabulacion
    public function mostrarTabulaciones(Request $request){

        $encuestas = Encuesta::all();
        $boolean = False;

        $cont = 0;
        $html = "";
        $html .= "<table class='table table-bordered'>
                <thead class='thead-s'>
                <tr>";

        $html .= "<th>N°</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Funciones</th>";

        $html .= "</tr>
                </thead>
                <tbody>";

        $idUser = Auth::user()->id;
        $boolean = False;        

        foreach ($encuestas as $encuesta) {

            $id = $encuesta->id;
            $titulo = $encuesta->titulo;
            $descripcion = $encuesta->descripcion;
            $cont++;

            $html .="<tr class='border-dotted'>";

            $html .= "<td>$cont</td>";
            $html .= "<td>$titulo</td>";
            $html .= "<td>$descripcion</td>";

            $verificar = ResponderEncuesta::where('user_id', $idUser)
                                        ->where('encuesta_id', $id)
                                        ->get();
            foreach ($verificar as $verifica) {
                $boolean = True;
            }

            $html .= "<td><a id='$id' href='#' class='btn btn-success' value='tabulacion'>Tabulación</a></td>";

            $html .= "</tr>";           
        };

        $html .= "</tbody>
                </table>";

        return Response::json(array('html' => $html,));

    }

    // Muestra las tablas graficas
    public function mostrarGraficas(Request $request)
    {
        $html = "";
        $idEncuesta = null;
        $boolean = False;
        $cont = 0;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                ->select('preguntas.id')
                                ->where('encuestas.id', $idEncuesta)
                                ->where('preguntas.encuesta_id', $idEncuesta)
                                ->get();
        foreach ($preguntas as $pregunta) {
            $boolean = True;
            $idPregunta = $pregunta->id;

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($cerradas as $cerrada) {
                $id = $cerrada->id;
                $preguntaC = $cerrada->pregunta;
                $cont++;
                $contName = $cont.'.'.' '.$preguntaC;
                
                $html .= "<div class='col-md-12 col-ls-12 col-sm-12'>
                            <div class='col-md-10 col-ls-10 col-sm-10'>
                                <label for='checkbox$id'>$contName</label> 
                            </div>
                            <div class='col-md-12 col-ls-12 col-sm-12' id='div$id' style='padding-left: 0px;'>

                            </div>
                            <br /><br />                        
                        </div>";  

                $html .= "<div class='col-md-12 col-ls-12 col-sm-12' style='margin-bottom: 20px;'></div>";
            }                 
        }
 
        return Response::json(array('html' => $html, 'cont' => $cont, 'id' => $id));
    }

    public function mostrarG(Request $request)
    {
        $i = $_GET['i'];
        $html = "";
        $idEncuesta = null;
        $boolean = False;
        $cont = 0;
        $cont2 = 0;
        $bien = 0;
        $mal = 0;
        $tipo = $_GET['tipo'];

        $html = "<script type='text/javascript'>";

        $html .= "// Load the Visualization API and the corechart package.
                google.charts.load('current', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.charts.setOnLoadCallback(drawChart);";

        $html .= "// Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawChart() {";

        $html .= "var data = google.visualization.arrayToDataTable([
                ['Respuesta', 'Porcentaje'],";

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntas = Encuesta::join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                ->join('cerradas', 'preguntas.id', 'cerradas.pregunta_id')
                                ->select('preguntas.id')
                                ->where('encuestas.id', $idEncuesta)
                                ->where('preguntas.encuesta_id', $idEncuesta)
                                ->get();
        foreach ($preguntas as $pregunta) {
            $boolean = True;
            $idPregunta = $pregunta->id;

            $cerradas = Cerrada::where('pregunta_id', $idPregunta)
                                ->get();
            foreach ($cerradas as $cerrada) {
                $id = $cerrada->id;
                $preguntaC = $cerrada->pregunta;
                $cont++;                 
            }

            $cerrada_respuestas = Cerrada::join('respuesta_cerradas', 'cerradas.id', 'respuesta_cerradas.cerrada_id')
                                ->where('cerradas.id', $id)
                                ->get();
            foreach ($cerrada_respuestas as $cerrada_respuesta) {
                $idC = $cerrada_respuesta->id;
                $respuesta = $cerrada_respuesta->respuesta;
                $correcta = $cerrada_respuesta->correcta;

                $cont2 = 0;
                $bien = 0;
                $mal = 0;
                $responderEncuestas = ResponderEncuesta::join('respuestas', 'responder_encuestas.id', 'respuestas.realizarEncuesta_id')
                                        ->select('respuestas.respuesta')
                                        ->where('respuestas.pregunta_id', $idPregunta)
                                        ->where('respuestas.tipo', "cerrada")
                                                        ->get();
                foreach ($responderEncuestas as $responderEncuesta) {
                    $respuesta2 = $responderEncuesta->respuesta;
                    $cont2++;

                    if ($correcta == $respuesta2) {
                        $bien++;
                    }else{
                        $mal++;
                    }
                }
                
                if ($cont == $i) {
                    if ($respuesta == $correcta) {
                        $html .= "['correcto', $bien],";
                    }else{
                        $html .= "['incorrecto', $mal],";
                    }
                    
                }
                
            }  

            if ($cont == $i) {
                $html .= "]);";

                if ($tipo == "PieChart") {
                    $html .= "// Set chart options
                            var options = { title: '$preguntaC',
                                            legend: { position: 'bottom' },
                                            width: 400,
                                            height: 300,
                                            colors: ['#e9473f', '#009dcc', '#835ab7'],
                                            vAxis: {format: 'percent'},
                                            pieHole: 0.4,};";
                }else if ($tipo == "BarChart") {
                    $html .= "// Set chart options
                            var options = { title: '$preguntaC',
                                            legend: { position: 'none' },
                                            width: 400,
                                            height: 300,
                                            minValue: 0, 
                                            maxValue: 100,
                                            colors: ['#e9473f'],
                                            vAxis: {format: 'percent'},
                                            bubble: {textStyle: {fontSize: 11}}};"; 
                }else if ($tipo == "ComboChart") {
                    $html .= "// Set chart options
                            var options = { title: '$preguntaC',
                                            legend: { position: 'none' },
                                            width: 400,
                                            height: 300,
                                            minValue: 0, 
                                            maxValue: 100,
                                            colors: ['#e9473f', '#009dcc', '#835ab7'],
                                            vAxis: {format: 'percent'},
                                            seriesType: 'bars',
                                            series: {5: {type: 'line'}}};"; 
                }else if ($tipo == "ScatterChart") {
                    $html .= "// Set chart options
                            var options = { title: '$preguntaC',
                                            legend: { position: 'none' },
                                            width: 400,
                                            height: 300,
                                            minValue: 0, 
                                            maxValue: 100,
                                            colors: ['#e9473f', '#009dcc', '#835ab7'],
                                            vAxis: {format: 'percent'}};";  
                }     

                $html .= "// Instantiate and draw our chart, passing in some options.
                        var chart = new google.visualization.$tipo(document.getElementById('chart_div.$id'));
                        chart.draw(data, options);";

                $html .= "}";

                $html .= "</script>";

                $html .= "<div class='col-md-9 col-ls-9 col-sm-9' id='chart_div.$id'></div>";

                // $html .= "<div class='col-md-3 col-ls-3 col-sm-3' style='padding-left: 0px;'>
                // <button id='$id' class='boton-donut' type='button' style='margin-bottom: 10px;' value='PieChart'> </button>
                // <br />
                // <button id='$id' class='boton-bar' type='button' style='margin-bottom: 10px;' value='BarChart'> </button>
                // <br />
                // <button id='$id' class='boton-combo' type='button' style='margin-bottom: 10px;' value='ComboChart'> </button>
                // <br />
                // <button id='$id' class='boton-scatter' type='button' style='margin-bottom: 10px;' value='ScatterChart'> </button>
                // </div>";

                break;
            } 


        }
 
        return Response::json(array('html' => $html, 'idG' => $id,));
    }
}


