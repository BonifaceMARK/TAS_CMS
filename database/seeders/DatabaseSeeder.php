<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TasFile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TrafficViolationSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(EmployeeSeeder::class);
        
        // Use the TasFileFactory to generate fake data
        TasFile::factory()->count(1000)->create();
    }
}
