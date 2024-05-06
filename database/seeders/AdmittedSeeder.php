<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admitted;
use Faker\Factory as Faker;

class AdmittedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 1000) as $index) {
            Admitted::create([
                'resolution_no' => $faker->randomNumber(5),
                'top' => $faker->randomElement(['A', 'B', 'C']),
                'apprehending_officer' => $faker->name,
                'driver' => $faker->name,
                'violation' => $faker->sentence(3),
                'transaction_no' => $faker->uuid,
                'date_received' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'plate_no' => $faker->regexify('[A-Z]{3}-[0-9]{3}'), // Example pattern for license plate format
                'remarks' => $faker->sentence(6),
                'file_attach' => $faker->imageUrl(),
            ]);
        }
    }
}
