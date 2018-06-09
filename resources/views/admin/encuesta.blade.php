@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        
        @include('layouts.status')

        <div class="col-md-12 col-ls-12 col-sm-12"></div>

        <div class="col-md-12 col-ls-12 col-sm-12">
            <center><a class="btn btn-info" href="{{ url('/admin/crearEncuesta') }}">Crear encuesta</a></center>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br> 

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaEncuestas"></div>
    </div>
</div>
@endsection

@include('admin.modal.modalEditarEncuesta')

@section('javascript')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection