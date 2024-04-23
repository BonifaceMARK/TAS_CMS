<?php
// database/factories/TasFileFactory.php

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
            'CASE_NO' => $this->faker->randomNumber(5),
            'TOP' => $this->faker->sentence(),
            'NAME' => $this->faker->name(),
            'VIOLATION' => $this->faker->word(),
            'TRANSACTION_NO' => $this->faker->uuid(),
            'transaction_date' => $this->faker->date(),
            'REMARKS' => $this->faker->sentence(),
        ];
    }
}

