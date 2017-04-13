<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/calendar', 'API\v1\Calendar@index');
Route::get('/v1/calendar/{year}', 'API\v1\Calendar@index');
Route::get('/v1/calendar/{year}/{month}/{day?}', 'API\v1\Calendar@date');

Route::get('/v1/test', 'API\v1\Calendar@test');