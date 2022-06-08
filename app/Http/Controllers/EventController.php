<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEventRequest;
use App\Models\Calendar;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //get user events
        $events = $request->user()->calendars->flatMap(function ($calendar) {
            return $calendar->events;
        });
        return response(['events' => $events], Response::HTTP_OK);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEventRequest $request)
    {
        try {
            $calendar = Calendar::findorFail($request->calendar_id);
            if (Gate::allows('view-event', $calendar)) {
                $event = Event::create([
                    'title' => $request->title,
                    'calendar_id' => $request->calendar_id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'description' => $request->description
                ]);
                return response(['event' => $event], Response::HTTP_ACCEPTED);
            }
            return response(['message' => 'You are not authorized to create this event'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "calendar with id {$request->calendar} not found"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $calendar = Event::findorFail($request->event_id)->calendar;
            if (Gate::allows('view-event', $calendar)) {
                $event = Event::findorFail($request->event_id);
                return response(['event' => $event], Response::HTTP_ACCEPTED);
            }
            return response(['message' => 'You are not authorized to view this event'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Event with id {$request->event_id} not found"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $calendar = Event::findorFail($request->event_id)->calendar;
            if (Gate::allows('update-event', $calendar)) {
                $event = Event::findorFail($request->event_id)->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                ]);
                return response([
                    'message' => 'Event updated successfully',
                ], Response::HTTP_OK);
            }
            return response(['message' => 'You are not authorized to update this event'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Event with id {$request->event_id} not found"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $calendar = Event::findorFail($request->event_id)->calendar;
            if (Gate::allows('delete-event', $calendar)) {
                $event = Event::find($request->event_id);
                $event->delete();
                return response([
                    'message' => 'Event deleted successfully',
                ], Response::HTTP_OK);
            }
            return response(['message' => 'You are not authorized to delete this event'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Event with id {$request->event_id} not found"], Response::HTTP_NOT_FOUND);
        }
    }
}
