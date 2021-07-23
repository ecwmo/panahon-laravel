<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->double('elevation')->nullable();
            $table->date('date_installed')->nullable();
            $table->string('sms_system_type', 50)->nullable();
            $table->string('mobile_number', 50)->nullable()->unique();
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
