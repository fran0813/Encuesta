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
                </div>
            {{-- </div> --}}
        {{-- </div> --}}

        <div class="col-md-12 col-ls-12 col-sm-12"></div>


       <div class="col-md-12 col-ls-12 col-sm-12">
            <center>
                <form id="formCrearEncuesta">
                    {{ csrf_field() }}
                    <label class="form-control" for="titulo">Titulo de la encuesta</label>
                    <input class="form-control" type="text" id="titulo" placeholder="Ingrese el titulo">
                    <br>
                    <label class="form-control" for="descripcion">Descripción</label>
                    <textarea class="form-control" style="resize: none; height: 70px" id="descripcion" placeholder="Ingrese la descripción de la encuesta"></textarea>
                    <br>
                    <button class="btn btn-success" type="submit">Enviar</button>
                    <button class="btn btn-danger">Limpiar</button>
                </form>
            </center>
        </div>

        <div id="respuesta"></div>

        <br>
        <br>

        <div class="col-md-12 col-ls-12 col-sm-12"id="tablaEncuestas"></div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('js/adminEncuesta.js') }}"></script>
@endsection