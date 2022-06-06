<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
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
    public function index()
    {
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
    public function store(Request $request)
    {
        $calendar = Calendar::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
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
    public function show(Calendar $calendar)
    {
        if (Auth::user()->id == $calendar->user_id) {
            return response($calendar, Response::HTTP_OK);
        } else {
            return response(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
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
    public function update(Request $request, Calendar $calendar)
    {
        if (auth()->user()->id == $calendar->user_id) {
            $calendar->update($request->all());
            return response('Updated', Response::HTTP_ACCEPTED);
        }
        return response('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $calendar)
    {
        $calendar = Calendar::findOrFail($calendar->id);
        if (Gate::allows('calendar-delete', $calendar)) {
            Calendar::destroy($calendar->id);
            return response(['message' => 'Calendar deleted successfully'], Response::HTTP_OK);
        }
        return response(['message' => 'You are not authorized to delete this calendar'], Response::HTTP_FORBIDDEN);
    }
}
