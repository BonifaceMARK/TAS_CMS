<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestedHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contested_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tas_files_id');
            $table->foreign('tas_files_id')->references('id')->on('tas_files')->onDelete('cascade');
            $table->text('changes')->nullable();
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
        Schema::dropIfExists('contested_histories');
    }
}
