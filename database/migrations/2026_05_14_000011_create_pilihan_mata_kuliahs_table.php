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
        Schema::create('pilihan_mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rekomendasi_mata_kuliah_id')->constrained('rekomendasi_mata_kuliahs')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'rekomendasi_mata_kuliah_id'], 'pilihan_mk_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihan_mata_kuliahs');
    }
};
