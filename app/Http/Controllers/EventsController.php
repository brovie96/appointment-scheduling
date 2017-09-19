<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Event;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_event');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'start' => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"',
        'end'   => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"|after_or_equal:start|nullable'
      ]);
      $event = new Event;
      $event->user_id = $request->user_id;
      $event->title = $request->title;
      $event->description = $request->description;
      $event->start = $request->start;
      $event->end = $request->end;
      if($request->has('allDay')) //coming from drag-and-drop
        $event->allDay = $request->allDay;
      else //coming from form
      {
        $event->allDay = $request->has('allDayCheck') ? 1 : 0;
        if($event->end != NULL)
        {
          $start = new Carbon($event->start);
          $end = new Carbon($event->end);
          if(($event->allDay == 1 && strcmp($start->toDateString(), $end->toDateString()) == 0) || ($event->allDay == 0 && strcmp($start->toDateTimeString(), $end->toDateTimeString()) == 0))
            $event->end = NULL;
          else if($event->allDay == 1) //more intuitive end date for all-day events
            $event->end = $end->addDay();
        }
      }
      $event->save();
      return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('edit_event')->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'start' => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"',
        'end'   => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"|after_or_equal:start|nullable'
      ]);
      $event = Event::find($id);
      $event->title = $request->title;
      $event->description = $request->description;
      $event->start = $request->start;
      $event->end = $request->end;
      if($request->has('allDay')) //coming from drag-and-drop or resize
        $event->allDay = $request->allDay;
      else //coming from form
      {
        $event->allDay = $request->has('allDayCheck') ? 1 : 0;
        if($event->end != NULL)
        {
          $start = new Carbon($event->start);
          $end = new Carbon($event->end);
          if(($event->allDay == 1 && strcmp($start->toDateString(), $end->toDateString()) == 0) || ($event->allDay == 0 && strcmp($start->toDateTimeString(), $end->toDateTimeString()) == 0))
            $event->end = NULL;
          else if($event->allDay == 1) //more intuitive end date for all-day events
            $event->end = $end->addDay();
        }
      }
      $event->save();
      return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return redirect('/');
    }
}
