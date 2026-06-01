<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'semester_ideal',
        'minat_topik_id',
    ];

    public function minatTopik(): BelongsTo
    {
        return $this->belongsTo(MinatTopik::class);
    }

    public function nilaiPrasyaratMahasiswas(): HasMany
    {
        return $this->hasMany(NilaiPrasyaratMahasiswa::class);
    }
}
