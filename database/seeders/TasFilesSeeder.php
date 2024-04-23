<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TasFile;

class TasFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TasFile::factory()->count(10)->create();
    }
}

