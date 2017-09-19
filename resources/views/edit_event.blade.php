@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')

@can('update', App\Event::find($id))
<script>
  var start;
  var startlabel;
  var checkbox;
  var end;
  var endlabel;
  var deleteForm;

  function check() {
    if(checkbox.is(":checked")) {
      //alert("Box checked!");
      startlabel.html('Start Date (yyyy-mm-dd)');
      endlabel.html('End Date (optional)');
      var time = new Date(start.prop('value'));
      if(start.prop('value') != '') {
        time = new Date(start.prop('value'));
        start.prop('type', 'date');
        start.prop('value', time.toISOString().split('T')[0]);
      }
      else
        start.prop('type', 'date');
      if(end.prop('value') != '') {
        time = new Date(end.prop('value'));
        end.prop('type', 'date');
        end.prop('value', time.toISOString().split('T')[0]);
      }
      else
        end.prop('type', 'date');
    }
    else {
      //alert("Box unchecked!");
      startlabel.html('Start Date/Time<br>(yyyy-mm-ddThh:mm)');
      endlabel.html('End Date/Time (optional)');
      var time = new Date(start.prop('value'));
      if(start.prop('value') != '') {
        time = new Date(start.prop('value'));
        start.prop('type', 'datetime-local');
        start.prop('value', time.toISOString().split('T')[0] + "T00:00:00");
      }
      else
        start.prop('type', 'datetime-local');
      if(end.prop('value') != '') {
        time = new Date(end.prop('value'));
        end.prop('type', 'datetime-local');
        end.prop('value', time.toISOString().split('T')[0] + "T00:00:00");
      }
      else
        end.prop('type', 'datetime-local');
    }
  }

  function remove() {
    if(confirm("Are you sure you want to delete?"))
      deleteForm.submit();
  }

  $(document).ready(function() {
    start = $('#start');
    startlabel = $('#startlabel');
    checkbox = $('#allDayCheck');
    end = $('#end');
    endlabel = $('#endlabel');
    deleteForm = $('#deleteForm');
    if(checkbox.is(":checked")) {
      check();
      if({{ (old("start") != NULL) ? '1' : '0'}} != 0) {
        start.prop('value', '{{ old("start") }}');
        end.prop('value', '{{ old("end") }}');
      }
      else if(start.prop('value') == end.prop('value'))
        end.prop('value', '');
    }
  });
</script>
@endcan

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
                      <form class="form-horizontal" action="/api/event/{{ $id }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ (old('title') != NULL) ? old('title') : App\Event::find($id)->title }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{ (old('description') != NULL) ? old('description') : App\Event::find($id)->description }}" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                            <label id='startlabel' for="start" class="col-md-4 control-label">Start Date/Time<br>(yyyy-mm-ddThh:mm)</label>

                            <div class="col-md-6">
                                <input id="start" type="datetime-local" class="form-control" name="start" value="{{ (old('start') != NULL) ? old('start') : preg_split('/[\s]/', App\Event::find($id)->start)[0] . 'T' . preg_split('/[\s]/', App\Event::find($id)->start)[1] }}" required>
                                @if ($errors->has('start'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('end') ? ' has-error' : '' }}">
                            <label id='endlabel' for="end" class="col-md-4 control-label">End Date/Time (optional)</label>

                            <div class="col-md-6">
                                <input id="end" type="datetime-local" class="form-control" name="end" value="{{ (old('end') != NULL) ? old('end') : ((App\Event::find($id)->end != NULL) ? (App\Event::find($id)->allDay == 1 ? preg_split('/[\s]/', (new Carbon\Carbon(App\Event::find($id)->end))->subDay())[0] . 'T' . preg_split('/[\s]/', (new Carbon\Carbon(App\Event::find($id)->end))->subDay())[1] : preg_split('/[\s]/', App\Event::find($id)->end)[0] . 'T' . preg_split('/[\s]/', App\Event::find($id)->end)[1]) : '') }}">
                                @if ($errors->has('end'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('end') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input id="allDayCheck" type="checkbox" name="allDayCheck" onclick="check()" {{ old('allDayCheck') ? 'checked' : ((App\Event::find($id)->allDay == 1) ? 'checked' : '') }}> All Day Event
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                  Submit
                                </button>
                                <button type="button" class="btn btn-danger" onclick="remove()">
                                  Delete
                                </button>
                            </div>
                        </div>
                      </form>
                      <form id="deleteForm" action="/api/event/{{ $id }}" method="POST">
                        <input name="_method" type="hidden" value="DELETE">
                        {{ csrf_field() }}
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
