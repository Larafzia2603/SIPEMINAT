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
        Schema::create('rekomendasi_rules', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rule', 120);
            $table->foreignId('mata_kuliah_prasyarat_id')->nullable()->constrained('mata_kuliahs')->nullOnDelete();
            $table->string('nilai_minimum', 2)->nullable();
            $table->foreignId('minat_topik_id')->nullable()->constrained('minat_topiks')->nullOnDelete();
            $table->foreignId('mata_kuliah_rekomendasi_id')->constrained('mata_kuliahs')->cascadeOnDelete();
            $table->unsignedInteger('bobot_skor')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_rules');
    }
};
