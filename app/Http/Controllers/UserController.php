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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    // Redireccionar a seleccionar encuesta a responder
    public function responder(Request $request){
        return view('user.responder');
    }

    // Redireccionar a responder encuesta
    public function responderEncuesta(Request $request){
        return view('user.responderEncuesta');
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
            return redirect('/user/responder');
        }else{
            return redirect('/user/responderEncuesta');
        }
    }
}
