<?php

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


Route::post('/Calendar/register', [AuthController::class, 'register']);
Route::post('/Calendar/login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/Calendar/courses', [SchoolController::class, 'courses']);
    Route::post('/Calendar/courses/{course_id}', [SchoolController::class, 'enroll']);
    Route::post('/Calendar/logout', [AuthController::class, 'logout']);
});
