<?php

namespace Database\Seeders;

use App\Models\ObservationsStation;
use Illuminate\Database\Seeder;

class ObservationsObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ObservationsStation::factory()->times(10)->hasObservation(15)->create();
    }
}
