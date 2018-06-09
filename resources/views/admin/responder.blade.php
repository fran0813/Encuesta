@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <div class="col-md-12 col-ls-12 col-sm-12"></div>

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaEncuestasResponder"></div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('js/adminEncuestaResponder.js') }}"></script>
@endsection