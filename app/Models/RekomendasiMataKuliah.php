<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekomendasiMataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'mata_kuliah_id',
        'rule_id',
        'skor',
        'alasan',
        'is_overridden',
        'override_by',
    ];

    protected function casts(): array
    {
        return [
            'is_overridden' => 'boolean',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(RekomendasiRule::class, 'rule_id');
    }

    public function overrideBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'override_by');
    }

    public function overrideLogs(): HasMany
    {
        return $this->hasMany(RekomendasiOverrideLog::class);
    }
}
