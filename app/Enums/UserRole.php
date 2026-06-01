<?php

namespace App\Enums;

enum UserRole: string
{
    case Mahasiswa = 'mahasiswa';
    case DosenPa = 'dosen_pa';
    case Kaprodi = 'kaprodi';
    case Dekan = 'dekan';

    public function label(): string
    {
        return match ($this) {
            self::Mahasiswa => 'Mahasiswa',
            self::DosenPa => 'Dosen PA',
            self::Kaprodi => 'Kaprodi',
            self::Dekan => 'Dekan',
        };
    }
}
