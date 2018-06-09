{{-- Modal Crear --}}
<div class="modal fade bd-example-modal-lg" id="modalCrearPreguntaAbierta" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Crear pregunta abierta</h4>
            </div>
            
            <div id="modalCrearPreguntaAbierta" class="modal-body">

                <form id="formCrearPreguntaAbierta">
                    <label class="form-control" for="preguntaAbierta">Pregunta</label>
                    <input class="form-control" type="text" id="preguntaAbierta" placeholder="Ingrese la pregunta" required>
                    <br>
                    <button class="btn btn-success" type="submit">Enviar</button>
                </form>

                <div id="respuestaCrearPreguntaAbierta" class="col-lg-12 col-md-12 col-sm-12"></div>
                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>