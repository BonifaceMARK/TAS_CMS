<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tas_files', function (Blueprint $table) {
            $table->id();
            $table->string('CASE_NO')->nullable();
            $table->string('TOP')->nullable();
            $table->string('NAME')->nullable();
            $table->string('VIOLATION')->nullable();
            $table->string('TRANSACTION_NO')->nullable();
            $table->date('transaction_date')->nullable(); 
            $table->string('REMARKS')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tas_files');
    }
};
