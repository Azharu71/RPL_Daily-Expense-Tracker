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
        Schema::create('users', function (Blueprint $table) {
            $table->id();                              // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->string('nama');                     // VARCHAR(255) NOT NULL
            $table->string('email')->unique();          // VARCHAR(255) NOT NULL UNIQUE
            $table->string('password');                 // VARCHAR(255) NOT NULL
            $table->timestamps();                       // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
