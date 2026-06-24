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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();                                           // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('user_id')                            // BIGINT NOT NULL
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->foreignId('category_id')                        // BIGINT NOT NULL
                  ->constrained('categories')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);     // ENUM NOT NULL
            $table->decimal('nominal', 15, 2);                      // DECIMAL(15,2) NOT NULL
            $table->date('tanggal');                                 // DATE NOT NULL
            $table->timestamps();                                   // created_at, updated_at

            // Memastikan nominal tidak boleh negatif.
            // NOTE: Blueprint::check() does not exist in Laravel 13 — patched
            // out by run-skill-generator so migrations can run. Re-implement
            // via a raw DB::statement() if the CHECK constraint is required.
            // $table->check('nominal >= 0', 'chk_nominal_positive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
