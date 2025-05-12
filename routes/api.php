<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Http\Controllers\ThingSpeakController;
use App\Http\Controllers\Api\V1\ImageController;
use App\Http\Controllers\Api\V1\VideoController;

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::group(
    ["namespace" => "App\Http\Controllers\Api\V1", "prefix" => "v1"],
    function () {
        /*Routes for user authentication */
        Route::post("login", "UserController@login");

        // Route for accessing images using the api
        Route::get("/img", [ImageController::class, "show"]);

        // Route for accessing videos using the api
        Route::get("/vids", [VideoController::class, "show"]);
        //  route for returning the most recent videos only based on the date
        Route::get("/vids/latest", [VideoController::class, "showLatest"]);

        /*Routes for farm related information */
        Route::middleware("auth:sanctum")->group(function () {
            Route::post("logout", "UserController@logout");
            Route::get("farms", "FarmController@index");
            Route::get(
                "farms/most-productive",
                "FarmController@getMostProductiveFarm"
            );
            Route::get("farms/count", "FarmController@totalFarmsAndHives");
            Route::get(
                "farms/time-until-harvest",
                "FarmController@timeUntilHarvestSeason"
            );
            Route::get(
                "farms/supplementary-feeding",
                "FarmController@getFarmsRequiringSupplementaryFeeding"
            );
            Route::get("farms/{farm_id}/hives", "HiveController@index");
            Route::get(
                "farms/{farm_id}/temperature-stats",
                "FarmController@getFarmTemperatureStats"
            );
            Route::get(
                "farms/{farm_id}/temperature-average",
                "FarmController@getFarmAverageTemperature"
            );
            Route::get(
                "farms/{farm_id}/weight-average",
                "FarmController@getFarmAverageWeight"
            );
        });

        /*Routes for hive related information */
        Route::middleware("auth:sanctum")->group(function () {
            Route::get(
                "hives/{hive_id}/latest-weight",
                "HiveController@getLatestWeight"
            );
            Route::get(
                "hives/{hive_id}/latest-temperature",
                "HiveController@getLatestTemperature"
            );
            Route::get(
                "hives/{hive_id}/state",
                "HiveController@getCurrentHiveState"
            );
        });

        /*Routes for fetching hive parameter data given a certain date range */
        Route::group(["middleware" => "auth:sanctum"], function () {
            Route::get(
                "hives/{hive_id}/temperature/{from_date}/{to_date}",
                "HiveParameterDataController@getTemperatureForDateRange"
            );
            Route::get(
                "hives/{hive_id}/humidity/{from_date}/{to_date}",
                "HiveParameterDataController@getHumidityForDateRange"
            );
            Route::get(
                "hives/{hive_id}/weight/{from_date}/{to_date}",
                "HiveParameterDataController@getWeightForDateRange"
            );
            Route::get(
                "hives/{hive_id}/carbondioxide/{from_date}/{to_date}",
                "HiveParameterDataController@getCarbondioxideForDateRange"
            );
        });

        //thingSpeak routes
        // Outside the middleware group
        // Route::get('/thingspeak-data', function (Request $request) {
        //     $client = new Client();
        //     $response = $client->get('https://api.thingspeak.com/channels/2715993/feeds.json', [
        //         'query' => [
        //             'api_key' => 'RYCJH8H1B9CNX8UV',
        //             'results' => 12
        //         ]
        //     ]);
        //     return response()->json(json_decode($response->getBody(), true));
        // });
        // Route::get('/thingspeak-data', [ThingSpeakController::class, 'fetchAndStoreData']);

        /*Routes for fetching hive media data given a certain date range */
        Route::group(["middleware" => "auth:sanctum"], function () {
            Route::get(
                "hives/{hive_id}/images/{from_date}/{to_date}",
                "HiveMediaDataController@getImagesForDateRange"
            );
            Route::get(
                "hives/{hive_id}/videos/{from_date}/{to_date}",
                "HiveMediaDataController@getVideosForDateRange"
            );
            Route::get(
                "hives/{hive_id}/audios/{from_date}/{to_date}",
                "HiveMediaDataController@getAudiosForDateRange"
            );
        });

        Route::post('/upload', function (Request $request) {
            $filename = $request->header('File-Name', 'uploaded_file.bin');

            // Store raw file data
            Storage::disk('public')->put("esp/{$filename}", $request->getContent());

            return response()->json(['message' => "File $filename uploaded successfully."], 200);
        });
    }
);
