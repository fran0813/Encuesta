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

    // Establece el id de la encuesta cuando se crea
    public function idEncuesta(Request $request){

        $tipo = $_POST['tipo'];

        if($tipo == "crear"){

            $id = "";
            $idEncuestas = Encuesta::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idEncuestas as $idEncuesta) {
                $id = $idEncuesta->id;          
            };

            if($id != ""){
                $request->session()->put("idEncuesta",$id);
            }

        }else if($tipo == "editar"){
            $id = $_POST['idEncuesta'];

            $request->session()->put("idEncuesta",$id);
        }
        
        return Response::json(array('msg' => "ok", 'html' => $id));
    }

    // Establece el id de la encuesta cuando se crea
    public function idAbierta(Request $request){

        $id = $_POST['id'];

        $results = Abierta::where('pregunta_id', $id)->get();

        foreach ($results as $result) {
            $id = $result->id;
        }

        $request->session()->put("idAbierta",$id);

        return Response::json(array('msg' => "ok", 'html' => $id));
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

        return Response::json(array('msg' => 'ok', 'html' => $id));
    }

    // Establece el id de la pregunta cuando se crea
    public function idPreguntaCerrada(Request $request){

        $tipo = $_POST['tipo'];

        if($tipo == "crear"){

            $id = "";
            $idPreguntas = Cerrada::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idPreguntas as $idPregunta) {
                $id = $idPregunta->id;          
            };

            if($id != ""){
                $request->session()->put("idPreguntaCerrada",$id);
            }

        }else if($tipo == "editar"){
            $id = $_POST['idPreguntaCerrada'];

            $request->session()->put("idPreguntaCerrada",$id);
        }
        
        return Response::json(array('msg' => "ok", 'html' => $tipo));
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

    // Redireccionar a crear la encuesta
    public function encuesta(Request $request){
        return view('admin.encuesta');
    }

    // Redireccionar a crear la encuestas
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

    // Redireccionar a crear la preguntas
    public function preguntas(){
        return view('admin.preguntas');
    }

    // Muestra las preguntas
    public function mostrarPreguntas(Request $request){

        $idEncuesta = null;

        if($request->session()->get("idEncuesta") ){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $encuestas = Encuesta::where('id', $idEncuesta)->get();

        foreach ($encuestas as $encuesta) {
            // $idEncuesta = $encuesta->id;
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

    public function crearPreguntaAbierta(Request $request){
        $boolean = False;
        $html = "";

        $idEncuesta = null;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntaRecibida = $_GET['preguntaAbierta'];

        $verificarPreguntaAbiertas = DB::table('encuestas')
                                        ->join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('abiertas', 'preguntas.id', 'abiertas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'abiertas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('abiertas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaAbiertas as $verificarPreguntaAbierta) {
            $boolean = True;
        };

        $verificarPreguntaCerradas = DB::table('encuestas')
                                        ->join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
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

    public function crearPreguntaCerrada(Request $request){
        $boolean = False;
        $html = "";
        $preguntaCerradaBoolean = True;

        $idEncuesta = null;

        if($request->session()->get("idEncuesta")){
            $idEncuesta = $request->session()->get("idEncuesta");
        }

        $preguntaRecibida = $_GET['preguntaCerrada'];

        $verificarPreguntaAbiertas = DB::table('encuestas')
                                        ->join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
                                        ->join('abiertas', 'preguntas.id', 'abiertas.pregunta_id')
                                        ->select('encuestas.*', 'preguntas.*', 'abiertas.*')
                                        ->where('encuestas.id', $idEncuesta)
                                        ->where('abiertas.pregunta', $preguntaRecibida)
                                        ->get();

        foreach ($verificarPreguntaAbiertas as $verificarPreguntaAbierta) {
            $boolean = True;         
        };

        $verificarPreguntaCerradas = DB::table('encuestas')
                                        ->join('preguntas', 'encuestas.id', 'preguntas.encuesta_id')
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

    public function crearRespuestaCerrada(Request $request){

        $boolean = False;
        $html = "";

        $idPregunta = null;

        if($request->session()->get("idPreguntaCerrada")){
            $idPregunta = $request->session()->get("idPreguntaCerrada");
        }

        $respuestaRecibida = $_GET['respuestaPregunta'];

        $verificarRespuestasCerradas = DB::table('cerradas')
                                        ->join('respuesta_cerradas', 'cerradas.id', 'respuesta_cerradas.cerrada_id')
                                        ->select('cerradas.*', 'respuesta_cerradas.*')
                                        ->where('cerradas.pregunta_id', $idPregunta)
                                        ->where('respuesta_cerradas.respuesta', $respuestaRecibida)
                                        ->get();

        foreach ($verificarRespuestasCerradas as $verificarRespuestasCerrada) {
            $boolean = True;         
        };
                                    
        if($boolean == False){

            $idPreguntas = Cerrada::orderBy('id', 'desc')
                                    ->limit(1)
                                    ->get();

            foreach ($idPreguntas as $idPregunta) {
                $idPregunta = $idPregunta->id;
            }

            $respuestaCerrada = new RespuestaCerrada;
            $respuestaCerrada->respuesta = $respuestaRecibida;
            $respuestaCerrada->cerrada_id = $idPregunta;
            $respuestaCerrada->save();

            $html = "<p>Se ha creado la pregunta con éxito</p>";
        }else{
            $html = "<p>La pregunta ya existe</p>";            
        }

        return Response::json(array('html' => $idPregunta,));
    }

    public function mostrarRespuestasCerradas(Request $request){
        
        $idPreguntaCerrada = null;

        if($request->session()->get("idPreguntaCerrada") ){
            $idPreguntaCerrada = $request->session()->get("idPreguntaCerrada");
        }

        if($request->session()->get("idCerrada") ){
            $idCerrada = $request->session()->get("idCerrada");
        }

        $tipo = $_GET['tipo'];

        if($tipo == "crear"){
            $respuestasCerradas = RespuestaCerrada::where('cerrada_id', $idCerrada)->get();
        }else if($tipo == "editar"){
            $respuestasCerradas = RespuestaCerrada::where('id', $idPreguntaCerrada)->get();
        }        

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

        return Response::json(array('html' => $html, 'id' => $idPreguntaCerrada));

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
            $pregunta = $cerrada->pregunta;
        }

        $abiertas = Abierta::where('pregunta_id', $id)->get();

        foreach ($abiertas as $abierta) {
            $boolean = "abierta";
            $idAbierta = $abierta->id;
            $pregunta = $abierta->pregunta;
        }

        if($boolean == "cerrada"){
            return Response::json(array('idCerrada' => $idCerrada, 'pregunta' => $pregunta, 'tipo' => $boolean));
        }else if($boolean == "abierta"){
            return Response::json(array('pregunta' => $pregunta, 'tipo' => $boolean));
        }
    }

    public function mostrarActualizarRespuestaCerrada(Request $request)
    {
        $id = $_GET['id'];

        $results = RespuestaCerrada::where('id', $id)->get();

        foreach ($results as $result) {
           $id = $result->id;
           $respuesta = $result->respuesta;
        }

        return Response::json(array('id' => $id, 'respuesta' => $respuesta));
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

        if($request->session()->get("idPreguntaCerrada") ){
            $id = $request->session()->get("idPreguntaCerrada");
        }

        $respuesta = $_GET['respuestaCerrada'];

        $html = "";

        $respuestaCerrada = RespuestaCerrada::find($id);

        $respuestaCerrada->respuesta = $respuesta;

        $respuestaCerrada->save();

        $html = "Se actualizo la pregunta correctamente";

        return Response::json(array('html' => $html, 'id' => $id));
    }

    public function verdadera(Request $request)
    {
        $idCerrada = $_GET['id'];

        $results = RespuestaCerrada::where('id', $idCerrada)->get();

        foreach ($results as $result) {
            $respuesta = $result->respuesta;
            $id = $result->cerrada_id;
        }

        $verdadera = Cerrada::find($id);

        $verdadera->correcta = $respuesta;

        $verdadera->save();

        return Response::json(array('msg' => "ok",));
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
}
