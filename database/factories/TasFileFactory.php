<?php

namespace Database\Factories;

use App\Models\TasFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class TasFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TasFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'case_no' => $this->faker->randomNumber(6),
            'top' => $this->faker->text(10),
            'apprehending_officer' => $this->faker->name,
            'driver' => $this->faker->name,
            'violation' => $this->faker->word,
            'transaction_no' => $this->faker->text(10),
            'date_received' => $this->faker->date(),
            'contact_no' => $this->faker->phoneNumber,
            'plate_no' => $this->faker->text(10),
            'remarks' => $this->faker->sentence,
            'file_attach' => $this->faker->word . '.pdf',
            'history' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['closed', 'in-progress', 'settled', 'unsettled']),
            'typeofvehicle' => $this->faker->randomElement(['Car', 'Truck', 'Motorcycle']),
            'fine_fee' => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
