<?php

namespace App\Http\Controllers\DosenPa;

use App\Http\Controllers\Controller;
use App\Http\Requests\DosenPa\OverrideRecommendationRequest;
use App\Models\RekomendasiMataKuliah;
use App\Models\RekomendasiOverrideLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BimbinganController extends Controller
{
    public function index(Request $request): View
    {
        /** @var \App\Models\User $dosen */
        $dosen = $request->user();
        $dosen->load([
            'mahasiswaBimbingan.minatTopiks',
            'mahasiswaBimbingan.rekomendasiMataKuliahs.mataKuliah',
            'mahasiswaBimbingan.rekomendasiMataKuliahs.overrideBy',
            'mahasiswaBimbingan.rekomendasiMataKuliahs.overrideLogs.dosenPa',
        ]);

        return view('dosen-pa.bimbingan', [
            'dosen' => $dosen,
            'mahasiswas' => $dosen->mahasiswaBimbingan,
        ]);
    }

    public function override(OverrideRecommendationRequest $request): RedirectResponse
    {
        $dosen = $request->user();

        $rekomendasi = RekomendasiMataKuliah::query()->with('mahasiswa')->findOrFail($request->validated('rekomendasi_id'));

        if (! $dosen->mahasiswaBimbingan()->where('users.id', $rekomendasi->mahasiswa_id)->exists()) {
            abort(403, 'Rekomendasi ini bukan milik mahasiswa bimbingan Anda.');
        }

        $alasanSebelumnya = $rekomendasi->alasan;

        $rekomendasi->update([
            'is_overridden' => true,
            'override_by' => $dosen->id,
            'alasan' => $request->validated('alasan'),
        ]);

        RekomendasiOverrideLog::query()->create([
            'rekomendasi_mata_kuliah_id' => $rekomendasi->id,
            'dosen_pa_id' => $dosen->id,
            'alasan_sebelumnya' => $alasanSebelumnya,
            'alasan_baru' => $request->validated('alasan'),
        ]);

        return redirect()->route('dosen-pa.bimbingan.index')->with('status', 'Rekomendasi berhasil dioverride.');
    }

    public function updateOverride(Request $request, RekomendasiMataKuliah $rekomendasiMataKuliah): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:255'],
        ]);

        $dosen = $request->user();

        if (! $dosen->mahasiswaBimbingan()->where('users.id', $rekomendasiMataKuliah->mahasiswa_id)->exists()) {
            abort(403, 'Rekomendasi ini bukan milik mahasiswa bimbingan Anda.');
        }

        $alasanSebelumnya = $rekomendasiMataKuliah->alasan;
        $alasanBaru = (string) $request->input('alasan');

        $rekomendasiMataKuliah->update([
            'is_overridden' => true,
            'override_by' => $dosen->id,
            'alasan' => $alasanBaru,
        ]);

        RekomendasiOverrideLog::query()->create([
            'rekomendasi_mata_kuliah_id' => $rekomendasiMataKuliah->id,
            'dosen_pa_id' => $dosen->id,
            'alasan_sebelumnya' => $alasanSebelumnya,
            'alasan_baru' => $alasanBaru,
        ]);

        return redirect()->route('dosen-pa.bimbingan.index')->with('status', 'Alasan override berhasil diperbarui.');
    }

    public function deleteOverride(Request $request, RekomendasiMataKuliah $rekomendasiMataKuliah): RedirectResponse
    {
        $dosen = $request->user();

        if (! $dosen->mahasiswaBimbingan()->where('users.id', $rekomendasiMataKuliah->mahasiswa_id)->exists()) {
            abort(403, 'Rekomendasi ini bukan milik mahasiswa bimbingan Anda.');
        }

        $alasanSebelumnya = $rekomendasiMataKuliah->alasan;

        $rekomendasiMataKuliah->update([
            'is_overridden' => false,
            'override_by' => null,
            'alasan' => null,
        ]);

        RekomendasiOverrideLog::query()->create([
            'rekomendasi_mata_kuliah_id' => $rekomendasiMataKuliah->id,
            'dosen_pa_id' => $dosen->id,
            'alasan_sebelumnya' => $alasanSebelumnya,
            'alasan_baru' => 'Override dihapus oleh dosen PA.',
        ]);

        return redirect()->route('dosen-pa.bimbingan.index')->with('status', 'Override berhasil dihapus.');
    }

    public function updateOverrideLog(Request $request, RekomendasiOverrideLog $rekomendasiOverrideLog): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:255'],
        ]);

        /** @var RekomendasiOverrideLog $rekomendasiOverrideLog */
        $dosen = $request->user();
        $rekomendasiOverrideLog->load('rekomendasiMataKuliah.mahasiswa');
        $rekomendasi = $rekomendasiOverrideLog->rekomendasiMataKuliah;

        if (! $rekomendasi) {
            abort(404, 'Rekomendasi tidak ditemukan.');
        }

        if (! $dosen->mahasiswaBimbingan()->where('users.id', $rekomendasi->mahasiswa_id)->exists()) {
            abort(403, 'Rekomendasi ini bukan milik mahasiswa bimbingan Anda.');
        }

        $alasanBaru = (string) $request->input('alasan');
        $rekomendasiOverrideLog->update([
            'alasan_baru' => $alasanBaru,
        ]);

        $latestLog = $rekomendasi->overrideLogs()->latest('id')->first();

        if ($latestLog && $latestLog->id === $rekomendasiOverrideLog->id) {
            $rekomendasi->update([
                'alasan' => $alasanBaru,
                'is_overridden' => true,
                'override_by' => $latestLog->dosen_pa_id,
            ]);
        }

        return redirect()->route('dosen-pa.bimbingan.index')->with('status', 'Riwayat override berhasil diperbarui.');
    }

    public function deleteOverrideLog(Request $request, RekomendasiOverrideLog $rekomendasiOverrideLog): RedirectResponse
    {
        /** @var RekomendasiOverrideLog $rekomendasiOverrideLog */
        $dosen = $request->user();
        $rekomendasiOverrideLog->load('rekomendasiMataKuliah.mahasiswa');
        $rekomendasi = $rekomendasiOverrideLog->rekomendasiMataKuliah;

        if (! $rekomendasi) {
            abort(404, 'Rekomendasi tidak ditemukan.');
        }

        if (! $dosen->mahasiswaBimbingan()->where('users.id', $rekomendasi->mahasiswa_id)->exists()) {
            abort(403, 'Rekomendasi ini bukan milik mahasiswa bimbingan Anda.');
        }

        RekomendasiOverrideLog::query()
            ->whereKey($rekomendasiOverrideLog->getKey())
            ->delete();

        $latestLog = $rekomendasi->overrideLogs()->latest('id')->first();

        if ($latestLog) {
            $rekomendasi->update([
                'alasan' => $latestLog->alasan_baru,
                'is_overridden' => true,
                'override_by' => $latestLog->dosen_pa_id,
            ]);
        } else {
            $rekomendasi->update([
                'alasan' => null,
                'is_overridden' => false,
                'override_by' => null,
            ]);
        }

        return redirect()->route('dosen-pa.bimbingan.index')->with('status', 'Riwayat override berhasil dihapus.');
    }
}
