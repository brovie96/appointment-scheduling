<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Event;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
        'end'   => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"|after:start|nullable'
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
        $event->allDay = $request->has('allDayCheck') ? 1 : 0;
      $event->save();
      return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        'end'   => 'date_multi_format:"Y-m-d\TH:i:s","Y-m-d\TH:i","Y-m-d"|after:start|nullable'
      ]);
      $event = Event::find($id);
      $event->title = $request->title;
      $event->description = $request->description;
      $event->start = $request->start;
      $event->end = $request->end;
      if($request->has('allDay')) //coming from drag-and-drop
        $event->allDay = $request->allDay;
      else //coming from form
        $event->allDay = $request->has('allDayCheck') ? 1 : 0;
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
