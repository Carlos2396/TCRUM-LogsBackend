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


Route::group(['as' => 'api', 'namespace' => 'API', 'middleware' => ['auth:api']], function() {

    // Logs routes
    Route::get('logs', 'LogsController@index')->name('logs');
    Route::get('logs/{log}', 'LogsController@show')->name('logs.show');
    Route::post('logs', 'LogsController@store')->name('logs.store');
});