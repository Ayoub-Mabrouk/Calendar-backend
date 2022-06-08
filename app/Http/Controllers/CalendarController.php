<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $calendars = $user->calendars->load('events');
        return response(['calendars' => $calendars], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendar = Calendar::create([
            'name' => $request->name,
            'user_id' => $request->user()->id
        ]);
        return response([
            'message' => 'Calendar created',
            'calendar' => $calendar,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $calendar = Calendar::findOrFail($request->calendar_id);
            if (Gate::allows('view-calendar', $calendar)) {
                return response(['calendar' => $calendar], Response::HTTP_ACCEPTED);
            }
            return response(['message' => 'You are not authorized to see this calendar'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Calender with id {$request->calendar_id} not found"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $calendar = Calendar::findOrFail($request->id);
            if (Gate::allows('update-calendar', $calendar)) {
                $calendar->update([
                    'name' => $request->name,
                ]);
                return response(['message' => 'Calendar updated successfully'], Response::HTTP_ACCEPTED);
            }
            return response(['message' => 'You are not authorized to update this calendar'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Calender with id {$request->id} not found"], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $calendar = Calendar::findOrFail($request->id);
            if (Gate::allows('delete-calendar', $calendar)) {
                Calendar::destroy($calendar->id);
                return response(['message' => 'Calendar deleted successfully'], Response::HTTP_OK);
            }
            return response(['message' => 'You are not authorized to delete this calendar'], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $exception) {
            return response(['message' => "Calender with id {$request->id} not found"], Response::HTTP_NOT_FOUND);
        }
    }
}
