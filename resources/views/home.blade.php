@extends('layouts.app')

@section('content')
<script>
  $(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
      editable: true,
      ventLimit: true, // allow "more" link when too many events
    });

  });
</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome to appointment scheduling!</p>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
