<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rack_id');
            $table->foreign('rack_id')->references('id')->on('rack')->onDelete('cascade');
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->string('number');
            $table->string('title');
            $table->string('file');
            $table->string('status');
            $table->string('note');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('archive');
    }
}
