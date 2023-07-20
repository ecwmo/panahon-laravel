<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateObservationsMOObservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_mo_observation', function (Blueprint $table) {
            $table->id();
            $table->float('temp')->nullable()->comment('Temperature (°C)');
            $table->float('rh')->nullable()->comment('Relative Humidity (%)');
            $table->float('pres')->nullable()->comment('Pressure (hPa)');
            $table->float('wspd')->nullable()->comment('Wind Speed (m/s)');
            $table->float('wspdx')->nullable()->comment('Max Wind Speed (m/s)');
            $table->float('wdir')->nullable()->comment('Wind Direction (°)');
            $table->float('wdirx')->nullable()->comment('Direction of Max Wind (°)');
            $table->float('srad')->nullable()->comment('Solar Radiation (W/m2)');
            $table->float('td')->nullable()->comment('Dew Point Temperature (°C)');
            $table->float('wchill')->nullable()->comment('Wind Chill (°C)');
            $table->float('rr')->nullable()->comment('Rain Rate (mm/hr)');
            $table->float('rain')->nullable()->comment('Rain (mm)');
            $table->float('tx')->nullable()->comment('Max Temperature (°C)');
            $table->float('tn')->nullable()->comment('Min Temperature (°C)');
            $table->float('wrun')->nullable();
            $table->float('hi')->nullable()->comment('Heat Index');
            $table->float('thwi')->nullable();
            $table->float('thswi')->nullable();
            $table->float('senergy')->nullable()->comment('Solar Energy (Ly)');
            $table->float('sradx')->nullable()->comment('Max Solar Radiation (W/m2)');
            $table->float('uvi')->nullable()->comment('UV Index');
            $table->float('uvdose')->nullable()->comment('UV Dose (MEDS)');
            $table->float('uvx')->nullable()->comment('Max UV');
            $table->float('hdd')->nullable();
            $table->float('cdd')->nullable();
            $table->float('et')->nullable()->comment('Evapotranspiration (mm)');
            $table->integer('qc_level')->default(0)->comment('QC level');
            $table->dateTimeTz('timestamp');
            $table->bigInteger('station_id');
            $table->timestampsTz();
        });

        Schema::table('observations_mo_observation', function (Blueprint $table) {
            DB::statement('ALTER TABLE "observations_mo_observation" ADD CONSTRAINT "observations_mo_observation_station_id_fkey" FOREIGN KEY ("station_id") REFERENCES "observations_station" ("id") ON DELETE CASCADE ON UPDATE CASCADE');
            DB::statement('ALTER TABLE "observations_mo_observation" ADD CONSTRAINT "observations_mo_observation_station_id_timestamp_unique" UNIQUE ("station_id", "timestamp")');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "temp" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "rh" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "pres" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wspd" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wspdx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wdir" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wdirx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "srad" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "td" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wchill" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "rr" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "rain" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "tx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "tn" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "wrun" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "hi" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "thwi" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "thswi" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "senergy" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "sradx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "uvi" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "uvdose" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "uvx" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "hdd" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "cdd" TYPE REAL');
            DB::statement('ALTER TABLE "observations_mo_observation" ALTER COLUMN "et" TYPE REAL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations_mo_observation');
    }
}
