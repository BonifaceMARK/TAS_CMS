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
            'case_no' => $this->faker->randomNumber(5),
            'top' => $this->faker->sentence(),
            'apprehending_officer' => $this->faker->name(),
            'driver' => $this->faker->name(),
            'violation' => $this->faker->word(),
            'transaction_no' => $this->faker->uuid(),
            'transaction_date' => $this->faker->date(),
            'contact_no' => $this->faker->phoneNumber(), // Added contact_no field
            'plate_no' => $this->faker->bothify('???-####'),
            'remarks' => $this->faker->sentence(),
            'file_attach' => $this->faker->imageUrl(), 
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}