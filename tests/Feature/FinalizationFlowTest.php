<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FinalizationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_choose_recommendation_and_unchoose_it(): void
    {
        /** @var User $mahasiswa */
        $mahasiswa = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Mahasiswa,
            'prodi' => 'Informatika',
        ]);

        DB::table('minat_topiks')->insert([
            ['id' => 1, 'nama' => 'Kecerdasan Buatan', 'slug' => 'ai', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('mata_kuliahs')->insert([
            ['id' => 1, 'kode' => 'IF201', 'nama' => 'Algoritma dan Struktur Data', 'sks' => 3, 'semester_ideal' => 3, 'minat_topik_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kode' => 'IF351', 'nama' => 'Kecerdasan Buatan Lanjut', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('rekomendasi_rules')->insert([
            'nama_rule' => 'Rule AI',
            'mata_kuliah_prasyarat_id' => 1,
            'nilai_minimum' => 'B',
            'minat_topik_id' => 1,
            'mata_kuliah_rekomendasi_id' => 2,
            'bobot_skor' => 20,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($mahasiswa)->post(route('mahasiswa.academic-profile.store'), [
            'minat_topik_ids' => [1],
            'nilai' => [[
                'mata_kuliah_id' => 1,
                'nilai_huruf' => 'A',
                'nilai_angka' => 4,
            ]],
        ]);

        $chooseResponse = $this->actingAs($mahasiswa)->post(route('mahasiswa.rekomendasi.choose', 1));
        $chooseResponse->assertRedirect(route('mahasiswa.rekomendasi.index', absolute: false));

        $this->assertDatabaseHas('pilihan_mata_kuliahs', [
            'mahasiswa_id' => $mahasiswa->id,
            'rekomendasi_mata_kuliah_id' => 1,
        ]);

        $unchooseResponse = $this->actingAs($mahasiswa)->delete(route('mahasiswa.rekomendasi.unchoose', 1));
        $unchooseResponse->assertRedirect(route('mahasiswa.rekomendasi.index', absolute: false));

        $this->assertDatabaseMissing('pilihan_mata_kuliahs', [
            'mahasiswa_id' => $mahasiswa->id,
            'rekomendasi_mata_kuliah_id' => 1,
        ]);
    }

    public function test_dekan_report_groups_students_by_prodi(): void
    {
        /** @var User $dekan */
        $dekan = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Dekan,
            'prodi' => 'Informatika',
        ]);

        User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Mahasiswa,
            'prodi' => 'Informatika',
        ]);

        User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Mahasiswa,
            'prodi' => 'Sistem Informasi',
        ]);

        $response = $this->actingAs($dekan)->get(route('dekan.reports.index'));
        $response->assertOk();
        $response->assertSee('Jumlah Mahasiswa per Prodi');
        $response->assertSee('Informatika');
        $response->assertSee('Sistem Informasi');
    }
}
