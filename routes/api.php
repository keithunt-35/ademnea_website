<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingSpeakController;
use App\Http\Controllers\Admin\BeehiveInspectionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API v1 routes
Route::prefix('v1')->namespace('App\Http\Controllers\Api\V1')->group(function () {

    // Public routes
    Route::post('login', 'UserController@login');

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {

        // User
        Route::post('logout', 'UserController@logout');

        // Farm routes
        Route::get('farms', 'FarmController@index');
        Route::get('farms/most-productive', 'FarmController@getMostProductiveFarm');
        Route::get('farms/count', 'FarmController@totalFarmsAndHives');
        Route::get('farms/time-until-harvest', 'FarmController@timeUntilHarvestSeason');
        Route::get('farms/supplementary-feeding', 'FarmController@getFarmsRequiringSupplementaryFeeding');
        Route::get('farms/{farm_id}/hives', 'HiveController@index');
        Route::get('farms/{farm_id}/temperature-stats', 'FarmController@getFarmTemperatureStats');
        Route::get('farms/{farm_id}/temperature-average', 'FarmController@getFarmAverageTemperature');
        Route::get('farms/{farm_id}/weight-average', 'FarmController@getFarmAverageWeight');

        // Hive routes
        Route::get('hives/{hive_id}/latest-weight', 'HiveController@getLatestWeight');
        Route::get('hives/{hive_id}/latest-temperature', 'HiveController@getLatestTemperature');
        Route::get('hives/{hive_id}/state', 'HiveController@getCurrentHiveState');

        // Hive parameter data by date range
        Route::get('hives/{hive_id}/temperature/{from_date}/{to_date}', 'HiveParameterDataController@getTemperatureForDateRange');
        Route::get('hives/{hive_id}/humidity/{from_date}/{to_date}', 'HiveParameterDataController@getHumidityForDateRange');
        Route::get('hives/{hive_id}/weight/{from_date}/{to_date}', 'HiveParameterDataController@getWeightForDateRange');
        Route::get('hives/{hive_id}/carbondioxide/{from_date}/{to_date}', 'HiveParameterDataController@getCarbondioxideForDateRange');

        // Hive media data by date range
        Route::get('hives/{hive_id}/images/{from_date}/{to_date}', 'HiveMediaDataController@getImagesForDateRange');
        Route::get('hives/{hive_id}/videos/{from_date}/{to_date}', 'HiveMediaDataController@getVideosForDateRange');
        Route::get('hives/{hive_id}/audios/{from_date}/{to_date}', 'HiveMediaDataController@getAudiosForDateRange');
    });
});

// External form submission route
Route::post('/submit-inspection', [BeehiveInspectionController::class, 'storeInspection']);
