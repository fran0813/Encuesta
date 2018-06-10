@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        <div class="col-md-12 col-ls-12 col-sm-12"></div>

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaGraficas"></div>
        <input type="number" id="totalPreguntas" disabled="" value="" style="display: none;">
    </div>
</div>
@endsection

@section('javascript')
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('js/adminGraficas.js') }}"></script>
@endsection