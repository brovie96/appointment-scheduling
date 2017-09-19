@extends('layouts.app')

@section('title', 'Create Event')

@section('content')

@can('create', App\Event::class)
<script>
  var start;
  var startlabel;
  var checkbox;
  var end;
  var endlabel;

  function check() {
    if(checkbox.is(":checked")) {
      //alert("Box checked!");
      startlabel.html('Start Date (yyyy-mm-dd)');
      endlabel.html('End Date (optional)');
      var time;
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
      var time;
      if(start.prop('value') != '') {
        time = new Date(start.prop('value'));
        start.prop('type', 'date');
        start.prop('value', time.toISOString().split('T')[0]);
      }
      else
        start.prop('type', 'date');
      if(end.prop('value') != '') {
        time = new Date(end.prop('value'));
        end.prop('type', 'datetime-local');
        end.prop('value', time.toISOString().split('T')[0] + "T00:00:00");
      }
      else
        end.prop('type', 'datetime-local');
    }
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
    }
  });
</script>
@endcan

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Event</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @can('create', App\Event::class)
                      <form class="form-horizontal" action="/event" method="POST">
                        {{ csrf_field() }}
                        <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control" name="description" value="{{  old('description')  }}" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                            <label id='startlabel' for="start" class="col-md-4 control-label">Start Date/Time<br>(yyyy-mm-ddThh:mm)</label>

                            <div class="col-md-6">
                                <input id="start" type="datetime-local" class="form-control" name="start" value="{{ old('start') }}" required>
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
                                <input id="end" type="datetime-local" class="form-control" name="end" value="{{ old('end') }}">
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
                                        <input id="allDayCheck" type="checkbox" name="allDayCheck" onclick="check()" {{ old('allDayCheck') ? 'checked' : '' }}> All Day Event
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
                      You cannot create events.
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
