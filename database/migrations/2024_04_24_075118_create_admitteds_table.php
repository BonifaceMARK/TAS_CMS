<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admitteds', function (Blueprint $table) {
            $table->id();
            $table->string('top')->nullable();
            $table->string('name')->nullable();
            $table->string('violation')->nullable();
            $table->string('transaction_no')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('contact_no')->nullable(); // Add contact_no field
            $table->string('remarks')->nullable();
            $table->text('file_attach')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admitteds');
    }
};
