<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiOverrideLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekomendasi_mata_kuliah_id',
        'dosen_pa_id',
        'alasan_sebelumnya',
        'alasan_baru',
    ];

    public function rekomendasiMataKuliah(): BelongsTo
    {
        return $this->belongsTo(RekomendasiMataKuliah::class);
    }

    public function dosenPa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_pa_id');
    }
}
