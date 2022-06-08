<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', fn (Request $request) => $request->user());

    Route::group(['prefix' => 'calendars'], function () {
        Route::get('/', [CalendarController::class, 'index']);
        Route::get('/{calendar_id}', [CalendarController::class, 'show']);
        Route::post('/', [CalendarController::class, 'store']);
        Route::put('/', [CalendarController::class, 'update']);
        Route::delete('/', [CalendarController::class, 'destroy']);

        Route::group(['prefix' => '{calendar_id}/events'], function () {
            Route::get('/', [EventController::class, 'index']);
            Route::get('/{event_id}', [EventController::class, 'show']);
            Route::post('/', [EventController::class, 'store']);
            Route::put('/', [EventController::class, 'update']);
            Route::delete('/', [EventController::class, 'destroy']);
        });

        // Route::get('{calendar_id}/events',  [EventController::class, 'index']);
        // Route::get('{calendar}/events/{event}', [EventController::class, 'show']);
        // Route::post('{calendar}/events', [EventController::class, 'store']);
        // Route::put('{calendar}/events', [EventController::class, 'update']);
        // Route::delete('/{calendar}/events', [EventController::class, 'destroy']);
    });
});
