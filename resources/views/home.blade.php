@extends('layouts.app')

@section('title', 'Main Page')

@section('content')
<script>
  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({

      events: [
        @foreach(Auth::user()->events as $event)
        {
          eventid: {{ $event->id }},
          title: '{{ $event->title }}',
          description: '{{ $event->description }}',
          start: '{{ $event->start }}',
          @if($event->end !== NULL)
          end: '{{ $event->end }}',
          @else
          end: null,
          @endif
          @if($event->allDay == 1)
          allDay: true,
          @else
          allDay: false,
          @endif
          url: '/event/{{ $event->id }}/edit'
        },
        @endforeach
      ],
      eventRender: function(event, element) {
        element.prop('title', event.description);
      },
      eventDrop: function(event, delta, revertFunc) {
        if (!confirm("Are you sure about this change?")) {
          revertFunc();
        }
        else {
          $.ajax({
            url: 'event/' + event.eventid,
            method: 'PUT',
            data: {
              title: event.title,
              description: event.description,
              start: event.start.format(),
              end: (event.end != null) ? event.end.format() : null,
              allDay: event.allDay ? 1 : 0
            }
          });
        }
      },
      eventResize: function(event, delta, revertFunc) {
        if (!confirm("is this okay?")) {
          revertFunc();
        }
        else {
          $.ajax({
            url: 'event/' + event.eventid,
            method: 'PUT',
            data: {
              title: event.title,
              description: event.description,
              start: event.start.format(),
              end: (event.end != null) ? event.end.format() : null,
              allDay: event.allDay ? 1 : 0
            }
          });
        }
      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      customButtons: {
        create: {
          text: 'new event',
          click: function() {
            window.location = '/event/create';
          }
        }
      },
      header: {
        left:   'today prev,next',
        center: 'title',
        right:  'create month,agendaWeek,agendaDay'
      },
    });

  });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Main Page</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
