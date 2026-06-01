<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PilihanMataKuliah;
use App\Services\RecommendationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function index(): View
    {
        $mahasiswa = request()->user()->load([
            'rekomendasiMataKuliahs.mataKuliah',
            'rekomendasiMataKuliahs.mataKuliah.minatTopik',
            'rekomendasiMataKuliahs.overrideBy',
            'rekomendasiMataKuliahs.overrideLogs.dosenPa',
            'minatTopiks',
            'pilihanMataKuliahs.rekomendasiMataKuliah.mataKuliah',
            'pilihanMataKuliahs.rekomendasiMataKuliah.mataKuliah.minatTopik',
        ]);

        $rekomendasis = $mahasiswa->rekomendasiMataKuliahs->sortByDesc('skor')->values();
        $pilihanIds = $mahasiswa->pilihanMataKuliahs->pluck('rekomendasi_mata_kuliah_id')->all();

        $careerMap = [
            'ai' => ['Machine Learning Engineer', 'AI Engineer', 'Data Scientist'],
            'jaringan' => ['Network Engineer', 'Security Analyst', 'Cloud Network Specialist'],
            'bisnis' => ['Business Analyst', 'Product Analyst', 'Digital Transformation Specialist'],
        ];

        $careerPaths = [];

        foreach ($rekomendasis as $rekomendasi) {
            if (! in_array($rekomendasi->id, $pilihanIds, true)) {
                continue;
            }

            $slug = $rekomendasi->mataKuliah->minatTopik?->slug;

            foreach ($careerMap[$slug] ?? [] as $career) {
                $careerPaths[$career] = true;
            }
        }

        return view('mahasiswa.rekomendasi', [
            'mahasiswa' => $mahasiswa,
            'rekomendasis' => $rekomendasis,
            'pilihanIds' => $pilihanIds,
            'chartLabels' => $rekomendasis->map(fn ($item) => $item->mataKuliah->kode)->all(),
            'chartValues' => $rekomendasis->pluck('skor')->all(),
            'careerPaths' => array_keys($careerPaths),
        ]);
    }

    public function regenerate(RecommendationService $recommendationService): RedirectResponse
    {
        $mahasiswa = request()->user()->load(['minatTopiks', 'nilaiPrasyaratMahasiswas']);

        $recommendationService->generateForMahasiswa($mahasiswa);

        return redirect()->route('mahasiswa.rekomendasi.index')->with('status', 'Rekomendasi berhasil dihitung ulang.');
    }

    public function choose(int $rekomendasiMataKuliahId): RedirectResponse
    {
        $mahasiswa = request()->user();

        $rekomendasi = $mahasiswa->rekomendasiMataKuliahs()->whereKey($rekomendasiMataKuliahId)->firstOrFail();

        PilihanMataKuliah::query()->firstOrCreate([
            'mahasiswa_id' => $mahasiswa->id,
            'rekomendasi_mata_kuliah_id' => $rekomendasi->id,
        ]);

        return redirect()->route('mahasiswa.rekomendasi.index')->with('status', 'Mata kuliah berhasil dipilih.');
    }

    public function unchoose(int $rekomendasiMataKuliahId): RedirectResponse
    {
        $mahasiswa = request()->user();

        PilihanMataKuliah::query()
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('rekomendasi_mata_kuliah_id', $rekomendasiMataKuliahId)
            ->delete();

        return redirect()->route('mahasiswa.rekomendasi.index')->with('status', 'Pilihan mata kuliah dibatalkan.');
    }
}
