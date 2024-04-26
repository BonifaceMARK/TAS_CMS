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

        foreach (range(1, 10) as $index) {
            Admitted::create([
                'top' => $faker->randomElement(['A', 'B', 'C']),
                'name' => $faker->name,
                'violation' => $faker->sentence(3),
                'transaction_no' => $faker->uuid,
                'transaction_date' => $faker->date,
                'contact_no' => $faker->phoneNumber,
                'plate_no' => $faker->regexify('[A-Z]{3}-[0-9]{3}'), // Example pattern for license plate format
                'remarks' => $faker->sentence(6),
                'file_attach' => $faker->imageUrl(),
            ]);
        }
    }
}
