<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilihanMataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'rekomendasi_mata_kuliah_id',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function rekomendasiMataKuliah(): BelongsTo
    {
        return $this->belongsTo(RekomendasiMataKuliah::class);
    }
}
