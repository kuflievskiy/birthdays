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

Route::group(['prefix' => '/v1','namespace' => 'API\v1'], function()
{
    Route::get('test', 'Calendar@test');

    Route::get('ping', function (Request $request)
    {
        return response()->json('pong');
    });

    Route::get('calendar', 'Calendar@index');
    Route::get('calendar/{year}', 'Calendar@index');
    Route::get('calendar/{year}/{month}/{day?}', 'Calendar@date');
    //Route::get('test2/page/{page?}', 'Calendar@test2');
});
