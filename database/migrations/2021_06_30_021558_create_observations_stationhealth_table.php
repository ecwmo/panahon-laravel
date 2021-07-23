<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservationsStationHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_stationhealth', function (Blueprint $table) {
            $table->id();
            $table->double('vb1')->nullable()->comment('Voltage Power Board 1 (V)');
            $table->double('vb2')->nullable()->comment('Voltage Power Board 2 (V)');
            $table->double('curr')->nullable()->comment('Current (A)');
            $table->double('bp1')->nullable()->comment('Boost Power Board 1 (V)');
            $table->double('bp2')->nullable()->comment('Boost Power Board 2 (V)');
            $table->string('cm', 255)->nullable()->comment('Current Monitoring');
            $table->integer('ss')->nullable()->comment('GSM Signal Strength');
            $table->double('temp_arq')->nullable()->comment('Temperature of ARQ');
            $table->double('rh_arq')->nullable()->comment('Humidity of ARQ');
            $table->string('fpm', 255)->nullable()->comment('Flash Page (memory)');
            $table->text('error_msg')->nullable();
            $table->text('message')->nullable();
            $table->integer('data_count')->nullable();
            $table->string('data_status', 255)->nullable();
            $table->integer('minutes_difference')->nullable();
            $table->string('time_error', 255)->nullable();
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
        Schema::dropIfExists('observations_stationhealth');
    }
}
