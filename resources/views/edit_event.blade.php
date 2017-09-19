@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')

<script>
  var start;
  var startlabel;
  var checkbox;
  var end;
  var endlabel;

  function check() {
    if(checkbox.is(":checked")) {
      //alert("Box checked!");
      var time = new Date(start.prop('value'));
      start.prop('type', 'date');
      start.prop('value', time.toISOString().split('T')[0]);
      if(end.prop('value') != '') {
        time = new Date(end.prop('value'));
        end.prop('type', 'date');
        end.prop('value', time.toISOString().split('T')[0]);
      }
      else
        end.prop('type', 'date');
      startlabel.html('Start Date (yyyy-mm-dd)');
      endlabel.html('End Date (optional)');
    }
    else {
      //alert("Box unchecked!");
      var time = new Date(start.prop('value'));
      start.prop('type', 'datetime-local');
      start.prop('value', time.toISOString().split('T')[0] + "T00:00:00");
      if(end.prop('value') != '') {
        time = new Date(end.prop('value'));
        end.prop('type', 'datetime-local');
        end.prop('value', time.toISOString().split('T')[0] + "T00:00:00");
      }
      else
        end.prop('type', 'datetime-local');
      startlabel.html('Start Date/Time<br>(yyyy-mm-ddThh:mm)');
      endlabel.html('End Date/Time (optional)');
    }
  }

  $(document).ready(function() {
    start = $('#start');
    startlabel = $('#startlabel');
    checkbox = $('#allDayCheck');
    end = $('#end');
    endlabel = $('#endlabel');
    if(checkbox.is(":checked"))
      check();
  });
</script>

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
                            <label id='startlabel' for="start" class="col-md-4 control-label">Start Date/Time<br>(yyyy-mm-ddThh:mm)</label>

                            <div class="col-md-6">
                                <input id="start" type="datetime-local" class="form-control" name="start" value="{{ preg_split('/[\s]/', App\Event::find($id)->start)[0] . 'T' . preg_split('/[\s]/', App\Event::find($id)->start)[1] }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label id='endlabel' for="start" class="col-md-4 control-label">End Date/Time (optional)</label>

                            <div class="col-md-6">
                                <input id="end" type="datetime-local" class="form-control" name="end" value="{{ (App\Event::find($id)->end != NULL) ? preg_split('/[\s]/', App\Event::find($id)->end)[0] . 'T' . preg_split('/[\s]/', App\Event::find($id)->end)[1] : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input id="allDayCheck" type="checkbox" name="allDayCheck" onclick="check()" {{ (App\Event::find($id)->allDay == 1) ? 'checked' : '' }}> All Day Event
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
