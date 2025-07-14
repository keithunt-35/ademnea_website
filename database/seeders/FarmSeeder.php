<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Farm;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all existing farmer IDs
        $farmerIds = \App\Models\Farmer::pluck('id')->toArray();
        
        if (empty($farmerIds)) {
            echo "⚠️  No farmers found. Please run FarmerSeeder first.\n";
            return;
        }
        
        echo "📊 Found " . count($farmerIds) . " farmers to assign farms to.\n";
        
        // Create 5 farms for the first farmer (our test farmer)
        $testFarmerId = $farmerIds[0];
        Farm::factory()->count(3)->create(['ownerId' => $testFarmerId]);
        echo "✅ Created 3 additional farms for test farmer (ID: $testFarmerId)\n";
        
        // Create farms for other farmers (distribute evenly)
        foreach (array_slice($farmerIds, 1) as $farmerId) {
            $farmCount = rand(1, 3); // Each farmer gets 1-3 farms
            Farm::factory()->count($farmCount)->create(['ownerId' => $farmerId]);
        }
        
        $totalFarms = \App\Models\Farm::count();
        echo "✅ Created total of $totalFarms farms across all farmers\n";
    }
}
