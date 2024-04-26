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
        // Seed the tas_files table with dummy data
        TasFile::create([
            'case_no' => 12345,
            'top' => 'Top Value',
            'apprehending_officer' => 'Officer Name',
            'driver' => 'Driver Name',
            'violation' => '["1", "2", "3"]',
            'transaction_no' => 'T123456',
            'contact_no' => '1234567890',
            'plate_no' => 'ABC123',
            'remarks' => 'Some remarks',
            'file_attach' => 'file.pdf',
            'created_at' => now(), // Add created_at field
            'updated_at' => now(), // Add updated_at field
        ]);

        // Add more seed data as needed
    }
}
