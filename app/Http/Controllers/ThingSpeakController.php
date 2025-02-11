<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ThingSpeakController extends Controller
{
    public function showMonitoring($hive_id)
    {
        return view('admin.Thingspeak.index', [
            'hive_id' => $hive_id
        ]);
    }
    public function fetchData($hive_id)
    {
        $client = new Client();

        //  ThingSpeak Read API Key and Channel ID
        $readApiKey ='QE5R1U1BVOW8IU74' ;
        $channelId = '2802273';

        $response = $client->get("https://api.thingspeak.com/channels/{$channelId}/feeds.json", [
            'query' => [
                'api_key' => $readApiKey,
                'results' => 12
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return response()->json([
            'feeds' => $data['feeds'],
            'channel' => $data['channel']
        ]);
    }


}
