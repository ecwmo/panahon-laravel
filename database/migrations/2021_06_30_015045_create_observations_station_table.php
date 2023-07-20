<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateObservationsStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_station', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->float('elevation')->nullable();
            $table->date('date_installed')->nullable();
            $table->string('mo_station_id', 50)->nullable();
            $table->string('sms_system_type', 50)->nullable();
            $table->string('mobile_number', 50)->nullable();
            $table->string('station_type', 50)->nullable();
            $table->string('station_type2', 50)->nullable();
            $table->string('station_url', 255)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('logger_version', 255)->nullable();
            $table->string('priority_level', 255)->nullable();
            $table->string('provider_id', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('province', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->timestampsTz();
            $table->softDeletes();
        });

        Schema::table('observations_station', function (Blueprint $table) {
            DB::statement('ALTER TABLE "observations_station" ADD CONSTRAINT "observations_station_mobile_number_unique" UNIQUE ("mobile_number")');
            DB::statement('ALTER TABLE "observations_station" ALTER COLUMN "lat" TYPE REAL');
            DB::statement('ALTER TABLE "observations_station" ALTER COLUMN "lon" TYPE REAL');
            DB::statement('ALTER TABLE "observations_station" ALTER COLUMN "elevation" TYPE REAL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations_station');
    }
}
