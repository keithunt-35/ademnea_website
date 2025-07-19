<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hive;

class HiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all existing farm IDs
        $farmIds = \App\Models\Farm::pluck('id')->toArray();
        
        if (empty($farmIds)) {
            echo "⚠️  No farms found. Please run FarmSeeder first.\n";
            return;
        }
        
        echo "📊 Found " . count($farmIds) . " farms to add hives to.\n";
        
        // Add hives to each farm (2-5 hives per farm)
        foreach ($farmIds as $farmId) {
            $hiveCount = rand(2, 5);
            Hive::factory()->count($hiveCount)->create(['farm_id' => $farmId]);
        }
        
        $totalHives = \App\Models\Hive::count();
        echo "✅ Created total of $totalHives hives across all farms\n";
    }
}
