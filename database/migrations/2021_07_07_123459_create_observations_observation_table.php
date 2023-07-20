<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateObservationsObservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_observation', function (Blueprint $table) {
            $table->id();
            $table->float('temp')->nullable()->comment('Temperature (°C)');
            $table->float('rh')->nullable()->comment('Relative Humidity (%)');
            $table->float('pres')->nullable()->comment('Pressure (hPa)');
            $table->float('wspd')->nullable()->comment('Wind Speed (m/s)');
            $table->float('wspdx')->nullable()->comment('Max Wind Speed (m/s)');
            $table->float('wdir')->nullable()->comment('Wind Direction (°)');
            $table->float('srad')->nullable()->comment('Solar Radiation (W/m2)');
            $table->float('td')->nullable()->comment('Dew Point Temperature (°C)');
            $table->float('wchill')->nullable()->comment('Wind Chill (°C)');
            $table->float('rr')->nullable()->comment('Rain Rate (mm/hr)');
            $table->float('mslp')->nullable()->comment('Mean Sea Level Pressure (hPa)');
            $table->float('hi')->nullable()->comment('Heat Index');
            $table->integer('qc_level')->default(0)->comment('QC level');
            $table->dateTimeTz('timestamp');
            $table->bigInteger('station_id');
            $table->timestampsTz();
        });

        Schema::table('observations_observation', function (Blueprint $table) {
            DB::statement('ALTER TABLE "observations_observation" ADD CONSTRAINT "observations_observation_station_id_fkey" FOREIGN KEY ("station_id") REFERENCES "observations_station" ("id") ON DELETE CASCADE ON UPDATE CASCADE');
            DB::statement('ALTER TABLE "observations_observation" ADD CONSTRAINT "observations_observation_station_id_timestamp_unique" UNIQUE ("station_id", "timestamp")');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "temp" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "rh" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "pres" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "wspd" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "wspdx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "wdir" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "srad" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "td" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "wchill" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "rr" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "mslp" TYPE REAL');
            DB::statement('ALTER TABLE "observations_observation" ALTER COLUMN "hi" TYPE REAL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations_observation');
    }
}
