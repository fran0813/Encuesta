@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        
        @include('layouts.status')

        <div class="col-md-12 col-ls-12 col-sm-12">
            <br>
            <br>
            <br>
        </div>

        <div class="col-md-12 col-ls-12 col-sm-12">
            <center><a class="btn btn-primary btn-lg" href="{{ url('/admin/crearEncuesta') }}">Crear encuesta</a></center>
        </div>

        <div class="col-md-12 col-ls-12 col-sm-12">
            <br>
            <br>
            <br>
        </div>

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaEncuestas"></div>
    </div>
</div>
@endsection

@include('admin.modal.modalEditarEncuesta')

@section('javascript')
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection