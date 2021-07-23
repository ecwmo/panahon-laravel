<?php

namespace Database\Factories;

use App\Models\ObservationsObservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservationsObservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObservationsObservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pres' => $this->faker->randomFloat(1, 980, 1100),
            'rr' => $this->faker->randomFloat(2, 0, 30),
            'temp' => $this->faker->randomFloat(2, 25, 37),
            'wdir' => $this->faker->numberBetween(0, 359),
            'wspd' => $this->faker->randomFloat(2, 2, 12),
            'rh' => $this->faker->randomFloat(2, 0, 100),
            'timestamp' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
