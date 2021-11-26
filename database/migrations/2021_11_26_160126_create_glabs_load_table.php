<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlabsLoadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glabs_load', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('promo')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->foreignId('glabs_id')
                ->constrained('glabs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('glabs_load');
    }
}
