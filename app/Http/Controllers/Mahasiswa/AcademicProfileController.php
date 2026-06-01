<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mahasiswa\StoreAcademicProfileRequest;
use App\Models\MataKuliah;
use App\Models\MinatTopik;
use App\Models\NilaiPrasyaratMahasiswa;
use App\Services\RecommendationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AcademicProfileController extends Controller
{
    public function index(): View
    {
        $mahasiswa = request()->user()->load(['minatTopiks', 'nilaiPrasyaratMahasiswas']);

        $minatTopiks = MinatTopik::query()->orderBy('nama', 'asc')->get();
        $mataKuliahs = MataKuliah::query()->orderBy('nama', 'asc')->get();

        $nilaiMap = $mahasiswa->nilaiPrasyaratMahasiswas->keyBy('mata_kuliah_id');

        return view('mahasiswa.academic-profile', [
            'mahasiswa' => $mahasiswa,
            'minatTopiks' => $minatTopiks,
            'mataKuliahs' => $mataKuliahs,
            'nilaiMap' => $nilaiMap,
        ]);
    }

    public function store(StoreAcademicProfileRequest $request, RecommendationService $recommendationService): RedirectResponse
    {
        $mahasiswa = $request->user();

        $mahasiswa->minatTopiks()->sync($request->validated('minat_topik_ids'));

        foreach ($request->validated('nilai') as $item) {
            NilaiPrasyaratMahasiswa::query()->updateOrCreate(
                [
                    'mahasiswa_id' => $mahasiswa->id,
                    'mata_kuliah_id' => $item['mata_kuliah_id'],
                ],
                [
                    'nilai_huruf' => strtoupper($item['nilai_huruf']),
                    'nilai_angka' => $item['nilai_angka'] ?? null,
                ]
            );
        }

        $recommendationService->generateForMahasiswa($mahasiswa->fresh(['minatTopiks', 'nilaiPrasyaratMahasiswas']));

        return redirect()->route('mahasiswa.rekomendasi.index')->with('status', 'Profil akademik berhasil disimpan dan rekomendasi diperbarui.');
    }
}
