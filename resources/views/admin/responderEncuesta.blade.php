@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <form method="POST" action='/admin/responderPreguntas'>
        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 col-ls-12 col-sm-12" id="preguntasRespondonder"></div>
        </form>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('js/adminPreguntasResponder.js') }}"></script>
@endsection