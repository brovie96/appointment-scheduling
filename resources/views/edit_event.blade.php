@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Event</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You have id of {{ $id }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
