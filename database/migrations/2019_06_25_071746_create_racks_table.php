<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rack', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('slot');
            $table->uuid('room_id');
            $table->foreign('room_id')->references('id')->on('room')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rack');
    }
}
