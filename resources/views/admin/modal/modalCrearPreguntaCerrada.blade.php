{{-- Modal Crear --}}
<div class="modal fade bd-example-modal-lg" id="modalCrearPreguntaCerrada" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Crear pregunta cerrada</h4>
            </div>
            
            <div id="modalCrearPreguntaCerrada" class="modal-body">

                <form id="formCrearPreguntaCerrada">
                    <label class="form-control" for="preguntaCerrada">Pregunta</label>
                    <input class="form-control" type="text" id="preguntaCerrada" placeholder="Ingrese la pregunta" required>
                    <br>
                    <button id="btnPreguntaCerrada" class="btn btn-success" type="submit">Enviar</button>
                </form>
                
                <div class="col-lg-12 col-md-12 col-sm-12" id="respuestaCrearPreguntaCerrada"></div>
                <br>
                
                <div id="respuestaVerdadera" class="col-lg-12 col-md-12 col-sm-12"></div>

                <br>
                <br>

                <form id="formCrearRespuestaCerrada">
                    <label class="form-control" for="respuestaPregunta">Respuesta</label>
                    <input class="form-control" type="text" id="respuestaPregunta" placeholder="Ingrese las posibles respuestas" disabled="">
                    <br>
                    <button id="btnRespuestaCerrada" class="btn btn-success" type="submit" disabled="">Enviar</button>
                    <button class="btn btn-danger" onclick="limpiar();">Limpiar</button>
                </form>
                
                <div id="respuestaCrearRespuestaCerrada" class="col-lg-12 col-md-12 col-sm-12"></div>

                <br><br>
                
                <div class="col-lg-12 col-md-12 col-sm-12" id="tablaRespuestasCerradas"></div>

                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>