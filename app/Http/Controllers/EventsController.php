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
        ['start_date', '>=', $request->start],
        ['start_date', '<=', $request->end]
      ])->select('id as eventid', 'title', 'description', 'start_date as start', 'end_date as end')->get();
    }

    public function update(Request $request)
    {
      $event = Event::find($request->id);
      $event->title = $request->title;
      $event->description = $request->description;
      $event->start_date = $request->start;
      $event->end_date = $request->end;
      $event->save();
    }
}
