{{-- Modal Editar --}}
<div class="modal fade bd-example-modal-lg" id="modalEditarPreguntaCerrada" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar pregunta cerrada</h4>
            </div>
            
            <div id="modalEditarPreguntaCerrada" class="modal-body">

                <form id="formEditarPreguntaCerrada">
                    <label class="form-control" for="preguntaCerrada2">Pregunta</label>
                    <input class="form-control" type="text" id="preguntaCerrada2" placeholder="Ingrese la pregunta" required>
                    <button id="btnPreguntaCerrada2" class="btn btn-success" type="submit">Enviar</button>
                    <br>
                </form>
                
                <div id="respuestaEditarPreguntaCerrada" class="col-lg-12 col-md-12 col-sm-12"></div>
                <br>

                <div id="respuestaVerdadera2" class="col-lg-12 col-md-12 col-sm-12"></div>

                <br><br>

                <form id="formCrearRespuestaCerrada2">
                    <label class="form-control" for="respuestaPregunta2">Respuesta</label>
                    <input class="form-control" type="text" id="respuestaPregunta2" placeholder="Ingrese las posibles respuestas" disabled="" required>
                    <br>
                    <button id="btnRespuestaCerrada2" class="btn btn-success" type="submit" disabled="">Enviar</button>
                </form>
                
                <br><br>

                <div id="respuestaCrearRespuestaCerrada2" class="col-lg-12 col-md-12 col-sm-12"></div>
                
                <div class="col-lg-12 col-md-12 col-sm-12" id="tablaRespuestasCerradas2"></div>

                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>