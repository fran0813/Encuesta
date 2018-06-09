{{-- Modal Editar --}}
<div class="modal fade bd-example-modal-lg" id="modalEditarRespuestaCerrada" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar respuesta cerrada</h4>
            </div>
            
            <div id="modalEditarRespuestaCerrada" class="modal-body">

                <form id="formEditarRespuestaCerrada">
                    <label class="form-control" for="respuestaCerrada2">Respuesta</label>
                    <input class="form-control" type="text" id="respuestaCerrada2" placeholder="Ingrese la pregunta" required>
                    <br>
                    <button class="btn btn-success" type="submit">Enviar</button>
                </form>

                <div id="respuestaEditarRespuestaCerrada" class="col-lg-12 col-md-12 col-sm-12"></div>
                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>