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
                      <form class="form-horizontal" action="/event/{{ $id }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ App\Event::find($id)->title }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ App\Event::find($id)->description }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start" class="col-md-4 control-label">Start Date/Time<br>(yyyy-mm-dd hh:mm)</label>

                            <div class="col-md-6">
                                <input id="start" type="datetime-local" class="form-control" name="start" value="{{ App\Event::find($id)->start }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="start" class="col-md-4 control-label">End Date/Time (optional)</label>

                            <div class="col-md-6">
                                <input id="end" type="datetime-local" class="form-control" name="end" value="{{ App\Event::find($id)->end }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="allDayCheck" {{ (App\Event::find($id)->allDay == 1) ? 'checked' : '' }}> All Day Event
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                      </form>
                    @else
                      You cannot edit this event.
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
