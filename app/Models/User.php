<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'nim', 'nip', 'email', 'password', 'role', 'prodi'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function nilaiPrasyaratMahasiswas(): HasMany
    {
        return $this->hasMany(NilaiPrasyaratMahasiswa::class, 'mahasiswa_id');
    }

    public function minatTopiks(): BelongsToMany
    {
        return $this->belongsToMany(MinatTopik::class, 'mahasiswa_minat_topiks', 'mahasiswa_id', 'minat_topik_id')
            ->withTimestamps();
    }

    public function rekomendasiMataKuliahs(): HasMany
    {
        return $this->hasMany(RekomendasiMataKuliah::class, 'mahasiswa_id');
    }

    public function pilihanMataKuliahs(): HasMany
    {
        return $this->hasMany(PilihanMataKuliah::class, 'mahasiswa_id');
    }

    public function mahasiswaBimbingan(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'dosen_pa_bimbingans', 'dosen_pa_id', 'mahasiswa_id')
            ->withTimestamps();
    }

    public function dosenPembimbing(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'dosen_pa_bimbingans', 'mahasiswa_id', 'dosen_pa_id')
            ->withTimestamps();
    }
}
