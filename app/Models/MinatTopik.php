<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MinatTopik extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
    ];

    public function mataKuliahs(): HasMany
    {
        return $this->hasMany(MataKuliah::class);
    }

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mahasiswa_minat_topiks', 'minat_topik_id', 'mahasiswa_id');
    }
}
