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
        Schema::create('rekomendasi_override_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekomendasi_mata_kuliah_id')->constrained('rekomendasi_mata_kuliahs')->cascadeOnDelete();
            $table->foreignId('dosen_pa_id')->constrained('users')->cascadeOnDelete();
            $table->text('alasan_sebelumnya')->nullable();
            $table->text('alasan_baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_override_logs');
    }
};
