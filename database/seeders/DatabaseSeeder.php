<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('rekomendasi_override_logs')->truncate();
        DB::table('pilihan_mata_kuliahs')->truncate();
        DB::table('rekomendasi_mata_kuliahs')->truncate();
        DB::table('rekomendasi_rules')->truncate();
        DB::table('nilai_prasyarat_mahasiswas')->truncate();
        DB::table('dosen_pa_bimbingans')->truncate();
        DB::table('mahasiswa_minat_topiks')->truncate();
        DB::table('mata_kuliahs')->truncate();
        DB::table('minat_topiks')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'name' => 'Mahasiswa Demo',
            'nim' => '2204010001',
            'nip' => null,
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Mahasiswa,
            'prodi' => 'Informatika',
        ]);

        User::create([
            'name' => 'Dosen PA Demo',
            'nip' => '19870101001',
            'email' => 'dosenpa@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::DosenPa,
            'prodi' => 'Informatika',
        ]);

        User::create([
            'name' => 'Kaprodi Demo',
            'nip' => '19791212002',
            'email' => 'kaprodi@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Kaprodi,
            'prodi' => 'Informatika',
        ]);

        User::create([
            'name' => 'Dekan Demo',
            'nip' => '19650505003',
            'email' => 'dekan@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Dekan,
            'prodi' => 'Informatika',
        ]);

        $mahasiswa = User::query()->where('nim', '2204010001')->firstOrFail();
        $dosenPa = User::query()->where('email', 'dosenpa@example.com')->firstOrFail();

        DB::table('minat_topiks')->insert([
            ['nama' => 'Kecerdasan Buatan', 'slug' => 'ai', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Jaringan', 'slug' => 'jaringan', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Bisnis Digital', 'slug' => 'bisnis', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('mata_kuliahs')->insert([
            ['kode' => 'IF201', 'nama' => 'Algoritma dan Struktur Data', 'sks' => 3, 'semester_ideal' => 3, 'minat_topik_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'IF351', 'nama' => 'Kecerdasan Buatan Lanjut', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'IF352', 'nama' => 'Jaringan Komputer Lanjut', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'IF353', 'nama' => 'Sistem Informasi Bisnis', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('dosen_pa_bimbingans')->insert([
            [
                'dosen_pa_id' => $dosenPa->id,
                'mahasiswa_id' => $mahasiswa->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('mahasiswa_minat_topiks')->insert([
            [
                'mahasiswa_id' => $mahasiswa->id,
                'minat_topik_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => $mahasiswa->id,
                'minat_topik_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('nilai_prasyarat_mahasiswas')->insert([
            [
                'mahasiswa_id' => $mahasiswa->id,
                'mata_kuliah_id' => 1,
                'nilai_huruf' => 'A',
                'nilai_angka' => 4.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('rekomendasi_rules')->insert([
            [
                'nama_rule' => 'Algoritma minimal B untuk AI Lanjut',
                'mata_kuliah_prasyarat_id' => 1,
                'nilai_minimum' => 'B',
                'minat_topik_id' => 1,
                'mata_kuliah_rekomendasi_id' => 2,
                'bobot_skor' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_rule' => 'Minat jaringan rekomendasikan jaringan lanjut',
                'mata_kuliah_prasyarat_id' => null,
                'nilai_minimum' => null,
                'minat_topik_id' => 2,
                'mata_kuliah_rekomendasi_id' => 3,
                'bobot_skor' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('rekomendasi_mata_kuliahs')->insert([
            [
                'mahasiswa_id' => $mahasiswa->id,
                'mata_kuliah_id' => 2,
                'rule_id' => 1,
                'skor' => 20,
                'alasan' => 'Algoritma minimal B untuk AI Lanjut',
                'is_overridden' => false,
                'override_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
