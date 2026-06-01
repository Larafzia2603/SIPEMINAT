<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MasterDataFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_kaprodi_can_manage_minat_topik(): void
    {
        /** @var User $kaprodi */
        $kaprodi = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Kaprodi,
        ]);

        $createResponse = $this->actingAs($kaprodi)->post(route('kaprodi.master-data.minat.store'), [
            'nama' => 'Kecerdasan Buatan',
        ]);

        $createResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseHas('minat_topiks', [
            'nama' => 'Kecerdasan Buatan',
            'slug' => 'kecerdasan-buatan',
        ]);

        $minatId = DB::table('minat_topiks')->where('nama', 'Kecerdasan Buatan')->value('id');

        $updateResponse = $this->actingAs($kaprodi)->put(route('kaprodi.master-data.minat.update', $minatId), [
            'nama' => 'AI dan Data',
        ]);

        $updateResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseHas('minat_topiks', [
            'id' => $minatId,
            'nama' => 'AI dan Data',
            'slug' => 'ai-dan-data',
        ]);

        $deleteResponse = $this->actingAs($kaprodi)->delete(route('kaprodi.master-data.minat.destroy', $minatId));
        $deleteResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseMissing('minat_topiks', [
            'id' => $minatId,
        ]);
    }

    public function test_kaprodi_can_manage_mata_kuliah(): void
    {
        /** @var User $kaprodi */
        $kaprodi = User::factory()->createOne([
            'email_verified_at' => now(),
            'role' => UserRole::Kaprodi,
        ]);

        DB::table('minat_topiks')->insert([
            ['id' => 1, 'nama' => 'Jaringan', 'slug' => 'jaringan', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $createResponse = $this->actingAs($kaprodi)->post(route('kaprodi.master-data.mata-kuliah.store'), [
            'kode' => 'IF401',
            'nama' => 'Jaringan Komputer Lanjut',
            'sks' => 3,
            'semester_ideal' => 5,
            'minat_topik_id' => 1,
        ]);

        $createResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseHas('mata_kuliahs', [
            'kode' => 'IF401',
            'nama' => 'Jaringan Komputer Lanjut',
            'sks' => 3,
            'semester_ideal' => 5,
            'minat_topik_id' => 1,
        ]);

        $mkId = DB::table('mata_kuliahs')->where('kode', 'IF401')->value('id');

        $updateResponse = $this->actingAs($kaprodi)->put(route('kaprodi.master-data.mata-kuliah.update', $mkId), [
            'kode' => 'IF402',
            'nama' => 'Jaringan Komputer Expert',
            'sks' => 4,
            'semester_ideal' => 6,
            'minat_topik_id' => 1,
        ]);

        $updateResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseHas('mata_kuliahs', [
            'id' => $mkId,
            'kode' => 'IF402',
            'nama' => 'Jaringan Komputer Expert',
            'sks' => 4,
            'semester_ideal' => 6,
        ]);

        $deleteResponse = $this->actingAs($kaprodi)->delete(route('kaprodi.master-data.mata-kuliah.destroy', $mkId));
        $deleteResponse->assertRedirect(route('kaprodi.master-data.index', absolute: false));

        $this->assertDatabaseMissing('mata_kuliahs', [
            'id' => $mkId,
        ]);
    }
}
