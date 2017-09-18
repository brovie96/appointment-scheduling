<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;

class EventsController extends Controller
{
    public function get(Request $request)
    {
      return Event::where([
        ['user_id', '=', $request->id],
        ['start', '>=', $request->start],
        ['start', '<=', $request->end]
      ])->select('id as eventid', 'title', 'description', 'start', 'end', 'allDay')->get();
    }

    public function update(Request $request)
    {
      $event = Event::find($request->id);
      $event->title = $request->title;
      $event->description = $request->description;
      $event->start = $request->start;
      $event->end = $request->end;
      $event->allDay = $request->allDay;
      $event->save();
    }
}
