<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->double('temp')->nullable()->comment('Temperature (°C)');
            $table->double('rh')->nullable()->comment('Relative Humidity (%)');
            $table->double('pres')->nullable()->comment('Pressure (hPa)');
            $table->double('wspd')->nullable()->comment('Wind Speed (m/s)');
            $table->double('wspdx')->nullable()->comment('Max Wind Speed (m/s)');
            $table->double('wdir')->nullable()->comment('Wind Direction (°)');
            $table->double('wdirx')->nullable()->comment('Direction of Max Wind (°)');
            $table->double('srad')->nullable()->comment('Solar Radiation (W/m2)');
            $table->double('td')->nullable()->comment('Dew Point Temperature (°C)');
            $table->double('wchill')->nullable()->comment('Wind Chill (°C)');
            $table->double('rr')->nullable()->comment('Rain Rate (mm/hr)');
            $table->double('rain')->nullable()->comment('Rain (mm)');
            $table->double('tx')->nullable()->comment('Max Temperature (°C)');
            $table->double('tn')->nullable()->comment('Min Temperature (°C)');
            $table->double('wrun')->nullable();
            $table->double('hi')->nullable()->comment('Heat Index');
            $table->double('thwi')->nullable();
            $table->double('thswi')->nullable();
            $table->double('senergy')->nullable()->comment('Solar Energy (Ly)');
            $table->double('sradx')->nullable()->comment('Max Solar Radiation (W/m2)');
            $table->double('uvi')->nullable()->comment('UV Index');
            $table->double('uvdose')->nullable()->comment('UV Dose (MEDS)');
            $table->double('uvx')->nullable()->comment('Max UV');
            $table->double('hdd')->nullable();
            $table->double('cdd')->nullable();
            $table->double('et')->nullable()->comment('Evapotranspiration (mm)');
            $table->integer('qc_level')->default(0)->comment('QC level');
            $table->dateTimeTz('timestamp');
            $table->foreignId('station_id')
                ->constrained('observations_station')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['station_id', 'timestamp']);
            $table->timestampsTz();
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
