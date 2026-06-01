<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RecommendationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_mahasiswa_can_submit_profile_and_get_recommendation(): void
    {
        /** @var User $mahasiswa */
        $mahasiswa = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Mahasiswa,
        ]);

        DB::table('minat_topiks')->insert([
            ['id' => 1, 'nama' => 'Kecerdasan Buatan', 'slug' => 'ai', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('mata_kuliahs')->insert([
            ['id' => 1, 'kode' => 'IF201', 'nama' => 'Algoritma dan Struktur Data', 'sks' => 3, 'semester_ideal' => 3, 'minat_topik_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kode' => 'IF351', 'nama' => 'Kecerdasan Buatan Lanjut', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('rekomendasi_rules')->insert([
            [
                'nama_rule' => 'Rule AI',
                'mata_kuliah_prasyarat_id' => 1,
                'nilai_minimum' => 'B',
                'minat_topik_id' => 1,
                'mata_kuliah_rekomendasi_id' => 2,
                'bobot_skor' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->actingAs($mahasiswa)->post(route('mahasiswa.academic-profile.store'), [
            'minat_topik_ids' => [1],
            'nilai' => [
                [
                    'mata_kuliah_id' => 1,
                    'nilai_huruf' => 'A',
                    'nilai_angka' => 4,
                ],
            ],
        ]);

        $response->assertRedirect(route('mahasiswa.rekomendasi.index', absolute: false));

        $this->assertDatabaseHas('rekomendasi_mata_kuliahs', [
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => 2,
            'skor' => 20,
        ]);
    }

    public function test_kaprodi_can_create_new_rule(): void
    {
        /** @var User $kaprodi */
        $kaprodi = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Kaprodi,
        ]);

        DB::table('minat_topiks')->insert([
            ['id' => 1, 'nama' => 'Jaringan', 'slug' => 'jaringan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('mata_kuliahs')->insert([
            ['id' => 1, 'kode' => 'IF210', 'nama' => 'Jaringan Komputer', 'sks' => 3, 'semester_ideal' => 3, 'minat_topik_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kode' => 'IF352', 'nama' => 'Jaringan Komputer Lanjut', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->actingAs($kaprodi)->post(route('kaprodi.rules.store'), [
            'nama_rule' => 'Rule Jaringan',
            'mata_kuliah_prasyarat_id' => 1,
            'nilai_minimum' => 'B',
            'minat_topik_id' => 1,
            'mata_kuliah_rekomendasi_id' => 2,
            'bobot_skor' => 15,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('kaprodi.rules.index', absolute: false));

        $this->assertDatabaseHas('rekomendasi_rules', [
            'nama_rule' => 'Rule Jaringan',
            'bobot_skor' => 15,
            'is_active' => true,
        ]);
    }

    public function test_kaprodi_can_update_and_delete_rule(): void
    {
        /** @var User $kaprodi */
        $kaprodi = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Kaprodi,
        ]);

        DB::table('minat_topiks')->insert([
            ['id' => 1, 'nama' => 'Bisnis Digital', 'slug' => 'bisnis', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('mata_kuliahs')->insert([
            ['id' => 1, 'kode' => 'IF220', 'nama' => 'Pengantar Bisnis Digital', 'sks' => 3, 'semester_ideal' => 3, 'minat_topik_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'kode' => 'IF353', 'nama' => 'Sistem Informasi Bisnis', 'sks' => 3, 'semester_ideal' => 5, 'minat_topik_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('rekomendasi_rules')->insert([
            'id' => 1,
            'nama_rule' => 'Rule Lama Bisnis',
            'mata_kuliah_prasyarat_id' => 1,
            'nilai_minimum' => 'C',
            'minat_topik_id' => 1,
            'mata_kuliah_rekomendasi_id' => 2,
            'bobot_skor' => 10,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $updateResponse = $this->actingAs($kaprodi)->put(route('kaprodi.rules.update', 1), [
            'nama_rule' => 'Rule Baru Bisnis',
            'mata_kuliah_prasyarat_id' => 1,
            'nilai_minimum' => 'B',
            'minat_topik_id' => 1,
            'mata_kuliah_rekomendasi_id' => 2,
            'bobot_skor' => 25,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect(route('kaprodi.rules.index', absolute: false));

        $this->assertDatabaseHas('rekomendasi_rules', [
            'id' => 1,
            'nama_rule' => 'Rule Baru Bisnis',
            'nilai_minimum' => 'B',
            'bobot_skor' => 25,
        ]);

        $deleteResponse = $this->actingAs($kaprodi)->delete(route('kaprodi.rules.destroy', 1));
        $deleteResponse->assertRedirect(route('kaprodi.rules.index', absolute: false));

        $this->assertDatabaseMissing('rekomendasi_rules', [
            'id' => 1,
        ]);
    }

    public function test_dosen_pa_override_creates_audit_log(): void
    {
        /** @var User $dosen */
        $dosen = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::DosenPa,
        ]);

        /** @var User $mahasiswa */
        $mahasiswa = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Mahasiswa,
        ]);

        DB::table('dosen_pa_bimbingans')->insert([
            'dosen_pa_id' => $dosen->id,
            'mahasiswa_id' => $mahasiswa->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('mata_kuliahs')->insert([
            'id' => 1,
            'kode' => 'IF351',
            'nama' => 'Kecerdasan Buatan Lanjut',
            'sks' => 3,
            'semester_ideal' => 5,
            'minat_topik_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rekomendasi_mata_kuliahs')->insert([
            'id' => 1,
            'mahasiswa_id' => $mahasiswa->id,
            'mata_kuliah_id' => 1,
            'rule_id' => null,
            'skor' => 15,
            'alasan' => 'Rekomendasi awal',
            'is_overridden' => false,
            'override_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($dosen)->post(route('dosen-pa.bimbingan.override'), [
            'rekomendasi_id' => 1,
            'alasan' => 'Pertimbangan konsultasi akademik',
        ]);

        $response->assertRedirect(route('dosen-pa.bimbingan.index', absolute: false));

        $this->assertDatabaseHas('rekomendasi_mata_kuliahs', [
            'id' => 1,
            'is_overridden' => true,
            'override_by' => $dosen->id,
            'alasan' => 'Pertimbangan konsultasi akademik',
        ]);

        $this->assertDatabaseHas('rekomendasi_override_logs', [
            'rekomendasi_mata_kuliah_id' => 1,
            'dosen_pa_id' => $dosen->id,
            'alasan_sebelumnya' => 'Rekomendasi awal',
            'alasan_baru' => 'Pertimbangan konsultasi akademik',
        ]);
    }
}
