<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Http;

use App\Models\Thingspeak;

use Carbon\Carbon;

class FetchThingSpeakData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:thingspeak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch data from thingspeak and feed it into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiKey = '696C6H35H7VH6VSA';
        $channelId = '2515358';
        $url = "https://api.thingspeak.com/channels/{$channelId}/feeds.json?api_key={$apiKey}&results=10";

        $response = Http::get($url);
        $data = $response->json();

        foreach ($data['feeds'] as $feed) {
            Thingspeak::create([
                'voltage' => $feed['field1'],
                'battery_percentage' => $feed['field2'],
                'created_at' => Carbon::parse($feed['created_at']),
            ]);
        }

        sleep(60);
        $this->info('Data fetched and stored successfully.');
    }
}
