@extends('layouts.baseAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{-- <div class="panel panel-default"> --}}
                {{-- <div class="panel-heading">Dashboard</div> --}}

                {{-- <div class="panel-body"> --}}
                   {{--  @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! Admin --}}
                {{-- </div> --}}
            {{-- </div> --}}
        {{-- </div> --}}

        <div class="col-md-12 col-ls-12 col-sm-12"></div>


        <div class="col-md-12 col-ls-12 col-sm-12">
            <label class="form-control" for="">Crear pregunta</label>
            <center><a class="btn btn-success" href="#" data-toggle="modal" data-target="#modalCrearPreguntaAbierta">Abierta</a>
            <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#modalCrearPreguntaCerrada" onclick="tablaRespuesta();">Cerrada</a></center>   
        </div>

        <br>
        <br>
        <br>
        <br>
        
        <div class="col-md-12 col-ls-12 col-sm-12" id="tituloEncuesta"></div>

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaPreguntas"></div>

        {{-- <div id="respuesta"></div> --}}

        <br>
        <br>

        <div class="col-md-12 col-ls-12 col-sm-12"id="tablaEncuestas"></div>
    </div>
</div>
@endsection

@include('admin.modal.modalCrearPreguntaAbierta')
@include('admin.modal.modalCrearPreguntaCerrada')
@include('admin.modal.modalEditarPreguntaAbierta')
@include('admin.modal.modalEditarPreguntaCerrada')
@include('admin.modal.modalEditarRespuestaCerrada')

@section('javascript')
    <script src="{{ asset('js/adminPreguntas.js') }}"></script>
@endsection