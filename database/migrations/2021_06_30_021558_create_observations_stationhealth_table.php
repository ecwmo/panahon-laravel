<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->float('vb1')->nullable()->comment('Voltage Power Board 1 (V)');
            $table->float('vb2')->nullable()->comment('Voltage Power Board 2 (V)');
            $table->float('curr')->nullable()->comment('Current (A)');
            $table->float('bp1')->nullable()->comment('Boost Power Board 1 (V)');
            $table->float('bp2')->nullable()->comment('Boost Power Board 2 (V)');
            $table->string('cm', 255)->nullable()->comment('Current Monitoring');
            $table->integer('ss')->nullable()->comment('GSM Signal Strength');
            $table->float('temp_arq')->nullable()->comment('Temperature of ARQ');
            $table->float('rh_arq')->nullable()->comment('Humidity of ARQ');
            $table->string('fpm', 255)->nullable()->comment('Flash Page (memory)');
            $table->text('error_msg')->nullable();
            $table->text('message')->nullable();
            $table->integer('data_count')->nullable();
            $table->string('data_status', 255)->nullable();
            $table->integer('minutes_difference')->nullable();
            $table->dateTimeTz('timestamp');
            $table->bigInteger('station_id');
            $table->timestampsTz();
        });

        Schema::table('observations_stationhealth', function (Blueprint $table) {
            DB::statement('ALTER TABLE "observations_stationhealth" ADD CONSTRAINT "observations_stationhealth_station_id_fkey" FOREIGN KEY ("station_id") REFERENCES "observations_station" ("id") ON DELETE CASCADE ON UPDATE CASCADE');
            DB::statement('ALTER TABLE "observations_stationhealth" ADD CONSTRAINT "observations_stationhealth_station_id_timestamp_unique" UNIQUE ("station_id", "timestamp")');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "vb1" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "vb2" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "curr" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "bp1" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "bp2" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "temp_arq" TYPE REAL');
            DB::statement('ALTER TABLE "observations_stationhealth" ALTER COLUMN "rh_arq" TYPE REAL');
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
