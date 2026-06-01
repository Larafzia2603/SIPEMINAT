<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\MinatTopik;
use App\Models\RekomendasiMataKuliah;
use App\Models\User;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $popularMataKuliah = RekomendasiMataKuliah::query()
            ->selectRaw('mata_kuliah_id, COUNT(*) as total', [])
            ->groupBy('mata_kuliah_id')
            ->orderByDesc('total')
            ->with('mataKuliah')
            ->get();

        return view('dekan.reports', [
            'totalMinat' => MinatTopik::query()->count('*'),
            'totalMataKuliah' => MataKuliah::query()->count('*'),
            'totalRekomendasi' => RekomendasiMataKuliah::query()->count('*'),
            'popularMataKuliah' => $popularMataKuliah,
            'chartLabels' => $popularMataKuliah->map(fn ($item) => $item->mataKuliah?->kode ?? 'N/A')->all(),
            'chartValues' => $popularMataKuliah->pluck('total')->all(),
            'prodiReports' => User::query()
                ->where('role', 'mahasiswa')
                ->selectRaw('COALESCE(prodi, "Belum diisi") as prodi, COUNT(*) as total', [])
                ->groupBy('prodi')
                ->orderByDesc('total')
                ->get(),
        ]);
    }
}
