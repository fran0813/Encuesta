@extends('layouts.baseUser')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }} User
                        </div>
                    @endif

                    You are logged in! User
                </div>
            </div>
        </div>
    </div>
</div>
@endsection