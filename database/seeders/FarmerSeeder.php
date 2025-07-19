<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Farm;
use App\Models\Hive;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if test user already exists, if so, use it; otherwise create it
        $testUser = User::where('email', 'test@example.com')->first();
        
        if (!$testUser) {
            $testUser = User::create([
                'name' => 'Test Farmer',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'role' => 'farmer',
            ]);
            echo "✅ Created new test user: test@example.com\n";
        } else {
            echo "ℹ️  Using existing test user: test@example.com\n";
        }

        // Check if farmer already exists for this user
        $testFarmer = $testUser->farmer;
        
        if (!$testFarmer) {
            $testFarmer = Farmer::create([
                'user_id' => $testUser->id,
                'fname' => 'Test',
                'lname' => 'Farmer',
                'gender' => 'Male',
                'address' => '123 Test Street, Test City',
                'telephone' => '+1234567890',
            ]);
            echo "✅ Created new farmer: {$testFarmer->fname} {$testFarmer->lname} (ID: {$testFarmer->id})\n";
        } else {
            echo "ℹ️  Using existing farmer: {$testFarmer->fname} {$testFarmer->lname} (ID: {$testFarmer->id})\n";
        }

        // Create a new farm for this farmer
        $testFarm = Farm::create([
            'ownerId' => $testFarmer->id,
            'name' => 'Test Farm ' . now()->format('Y-m-d H:i'),
            'district' => 'Test District',
            'address' => 'Test Farm Address, Test Location',
            'latitude' => 9.0579,
            'longitude' => 7.4951,
            'description' => 'A test farm for API testing',
        ]);

        // Create exactly 2 hives in the farm
        $hive1 = Hive::create([
            'farm_id' => $testFarm->id,
            'latitude' => 9.0580,
            'longitude' => 7.4952,
        ]);

        $hive2 = Hive::create([
            'farm_id' => $testFarm->id,
            'latitude' => 9.0581,
            'longitude' => 7.4953,
        ]);

        echo "✅ Created test farm: {$testFarm->name} (ID: {$testFarm->id})\n";
        echo "✅ Created 2 hives: Hive {$hive1->id} and Hive {$hive2->id}\n";

        // Create additional random farmers using factory (optional)
        $additionalFarmers = Farmer::factory()->count(3)->create();
        echo "✅ Created 3 additional random farmers\n";
        
        echo "\n📋 Summary:\n";
        echo "   - User Email: test@example.com\n";
        echo "   - Password: password\n";
        echo "   - Farmer ID: {$testFarmer->id}\n";
        echo "   - Farm ID: {$testFarm->id}\n";
        echo "   - Hive IDs: {$hive1->id}, {$hive2->id}\n";
    }
}
