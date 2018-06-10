@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        
        @include('layouts.status')

        <div class="col-md-12 col-ls-12 col-sm-12"></div>

        <div class="col-md-12 col-ls-12 col-sm-12" id="tablaTabulacion"></div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('js/adminTabulacion.js') }}"></script>
@endsection