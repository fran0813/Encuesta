{{-- Modal Editar --}}
<div class="modal fade bd-example-modal-lg" id="modalEditarPreguntaAbierta" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar pregunta abierta</h4>
            </div>
            
            <div id="modalEditarPreguntaAbierta" class="modal-body">

                <form id="formEditarPreguntaAbierta">
                    <label class="form-control" for="preguntaAbierta2">Pregunta</label>
                    <input class="form-control" type="text" id="preguntaAbierta2" placeholder="Ingrese la pregunta">
                    <br>
                    <button class="btn btn-success" type="submit">Enviar</button>
                </form>

                <div id="respuestaEditarPreguntaAbierta" class="col-lg-12 col-md-12 col-sm-12"></div>
                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>