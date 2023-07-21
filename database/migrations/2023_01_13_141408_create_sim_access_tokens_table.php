<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSimAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_access_tokens', function (Blueprint $table) {
            $table->string('access_token')->primary();
            $table->string('type', 50);
            $table->string('mobile_number', 50);
            $table->timestampsTz();
        });

        Schema::table('sim_access_tokens', function (Blueprint $table) {
            DB::statement('ALTER TABLE "sim_access_tokens" ADD CONSTRAINT "sim_access_tokens_mobile_number_fkey" FOREIGN KEY ("mobile_number") REFERENCES "sim_cards" ("mobile_number") ON DELETE CASCADE ON UPDATE CASCADE');
            DB::statement('ALTER TABLE "sim_access_tokens" ADD CONSTRAINT "sim_access_tokens_mobile_number_type_unique" UNIQUE ("mobile_number", "type")');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sim_access_tokens');
    }
};
