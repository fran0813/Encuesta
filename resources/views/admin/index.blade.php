@extends('layouts.baseAdmin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{-- <div class="panel panel-default"> --}}
                {{-- <div class="panel-heading">Dashboard</div> --}}

                {{-- <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! Admin
                </div> --}}
            {{-- </div> --}}
        {{-- </div> --}}

        <div class="col-md-12 col-ls-12 col-sm-12"></div>

        <div class="col-md-12 col-ls-12 col-sm-12">
            <center><a class="btn btn-info" href="{{ url('/admin/encuesta') }}">Crear encuesta</a></center>
        </div>

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