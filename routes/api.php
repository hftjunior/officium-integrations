<?php

use Illuminate\Http\Request;

Route::apiResource('notifications', 'Api\NotificationController');
Route::apiResource('states', 'Api\StateController');
Route::apiResource('cities', 'Api\CityController');
Route::apiResource('objects', 'Api\ObjectController');


Route::post('auth/login', 'Api\AuthController@login');
Route::group(['middleware' => ['apiJWT']], function(){
    Route::get('users', 'Api\UserController@index');
    Route::post('auth/me', 'Api\AuthController@me');
    Route::post('auth/refresh', 'Api\AuthController@refresh');
    Route::post('auth/logout', 'Api\AuthController@logout');

    Route::apiResource('units', 'Api\UnitController');
    Route::apiResource('ovens', 'Api\OvenController');
    Route::apiResource('productionstep', 'Api\CoalProductionStepController');
    Route::apiResource('temperatures', 'Api\CoalTemperatureController');
    Route::apiResource('temperaturepoints', 'Api\CoalTemperaturePointController');
    Route::apiResource('productionround', 'Api\CoalProductionRoundController');
    Route::get('ovensperunit/{id}/{limit}', 'Api\OvensPerUnitController@show');
    Route::get('ovendetails/{id}/{limit}', 'Api\OvenDetailsController@show');
});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
