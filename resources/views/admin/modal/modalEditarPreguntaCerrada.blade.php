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
                    <input class="form-control" type="text" id="preguntaCerrada2" placeholder="Ingrese la pregunta">
                    <button id="btnPreguntaCerrada" class="btn btn-success" type="submit">Enviar</button>
                    <br>
                </form>
                
                <div id="respuestaEditarPreguntaCerrada" class="col-lg-12 col-md-12 col-sm-12"></div>

                <br><br>
                
                <div class="col-lg-12 col-md-12 col-sm-12" id="tablaRespuestasCerradas2"></div>

                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>