<?php

namespace Database\Factories;

use App\Models\ObservationsStation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObservationsStationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ObservationsStation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $stationTypes = ['MO', 'SMS'];
        $stationStatuses = ['ACTIVE', 'INACTIVE'];

        return [
            'name' => $this->faker->word() . $this->faker->safeColorName(),
            'lat' => $this->faker->latitude(5, 19),
            'lon' => $this->faker->longitude(118, 125),
            'address' => $this->faker->address(),
            'station_type' => $stationTypes[$this->faker->numberBetween(0, 1)],
            'date_installed' => $this->faker->dateTimeBetween('-5 year', 'now'),
            'status' => $stationStatuses[$this->faker->numberBetween(0, 1)]
        ];
    }
}
