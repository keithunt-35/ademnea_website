<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin user already exists
        $adminUser = User::where('email', 'admin@admin.com')->first();
        
        if (!$adminUser) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password'=>bcrypt("admin..123")
            ]);
            echo "✅ Created admin user: admin@admin.com\n";
        } else {
            echo "ℹ️  Admin user already exists: admin@admin.com\n";
        }

        $this->call([
            FarmerSeeder::class,
            FarmSeeder::class,
            HiveSeeder::class,
            HiveTemperatureSeeder::class,
        ]);
    }
}
