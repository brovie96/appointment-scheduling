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
                    @can('update', App\Event::find($id))
                      You have id of {{ $id }}
                    @else
                      You cannot edit this event.
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
