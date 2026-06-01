<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekomendasiRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rule',
        'mata_kuliah_prasyarat_id',
        'nilai_minimum',
        'minat_topik_id',
        'mata_kuliah_rekomendasi_id',
        'bobot_skor',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function mataKuliahPrasyarat(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_prasyarat_id');
    }

    public function mataKuliahRekomendasi(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_rekomendasi_id');
    }

    public function minatTopik(): BelongsTo
    {
        return $this->belongsTo(MinatTopik::class);
    }

    public function rekomendasiMataKuliahs(): HasMany
    {
        return $this->hasMany(RekomendasiMataKuliah::class, 'rule_id');
    }
}
