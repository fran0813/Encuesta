{{-- Modal Editar --}}
<div class="modal fade bd-example-modal-lg" id="modalEditarEncuesta" role="dialog">

    <div class="modal-dialog modal-lg">

         {{-- Modal content --}}
        <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar encuesta</h4>
            </div>
            
            <div id="modalEditarEncuesta" class="modal-body">

                <form id="formEditarEncuesta">
                    <label class="form-control" for="tituloEncuesta">Titulo de la encuesta</label>
                    <input class="form-control" type="text" id="titulo2" placeholder="Ingrese el titulo" value="" required>
                    <br>
                    <label class="form-control" for="descripcion">Descripción</label>
                    <textarea class="form-control" style="resize: none; height: 70px" id="descripcion" placeholder="Ingrese la descripción de la encuesta"></textarea>
                    <br>
                    <button class="btn btn-success" type="submit">Enviar</button>
                </form>

                <button class="btn btn-info" onclick="redirigirPreguntas();">Editar preguntas</button>

                <div id="respuesta2" class="col-lg-12 col-md-12 col-sm-12"></div>
                <br>
            </div>

            <div class="modal-footer">
              
            </div>

        </div>

    </div>

</div>