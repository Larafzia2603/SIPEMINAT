<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\MinatTopik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    public function index(): View
    {
        return view('kaprodi.master-data.index', [
            'minatTopiks' => MinatTopik::query()->orderBy('nama', 'asc')->get(),
            'mataKuliahs' => MataKuliah::query()->with('minatTopik')->orderBy('kode', 'asc')->get(),
            'minatEdit' => null,
            'mkEdit' => null,
        ]);
    }

    public function editMinat(MinatTopik $minatTopik): View
    {
        return view('kaprodi.master-data.edit-minat', [
            'minatTopik' => $minatTopik,
        ]);
    }

    public function storeMinat(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:minat_topiks,nama'],
        ]);

        $slug = $this->uniqueSlug($data['nama']);

        MinatTopik::query()->create([
            'nama' => $data['nama'],
            'slug' => $slug,
        ]);

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Topik minat berhasil ditambahkan.');
    }

    public function updateMinat(Request $request, MinatTopik $minatTopik): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:minat_topiks,nama,'.$minatTopik->id],
        ]);

        $minatTopik->update([
            'nama' => $data['nama'],
            'slug' => $this->uniqueSlug($data['nama'], $minatTopik->id),
        ]);

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Topik minat berhasil diperbarui.');
    }

    public function destroyMinat(MinatTopik $minatTopik): RedirectResponse
    {
        MinatTopik::query()->whereKey($minatTopik->id)->delete();

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Topik minat berhasil dihapus.');
    }

    public function editMataKuliah(MataKuliah $mataKuliah): View
    {
        return view('kaprodi.master-data.edit-mata-kuliah', [
            'mataKuliah' => $mataKuliah->load('minatTopik'),
            'minatTopiks' => MinatTopik::query()->orderBy('nama', 'asc')->get(),
        ]);
    }

    public function storeMataKuliah(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:mata_kuliahs,kode'],
            'nama' => ['required', 'string', 'max:150'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester_ideal' => ['nullable', 'integer', 'min:1', 'max:14'],
            'minat_topik_id' => ['nullable', 'integer', 'exists:minat_topiks,id'],
        ]);

        MataKuliah::query()->create($data);

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Mata kuliah berhasil ditambahkan.');
    }

    public function updateMataKuliah(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:mata_kuliahs,kode,'.$mataKuliah->id],
            'nama' => ['required', 'string', 'max:150'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester_ideal' => ['nullable', 'integer', 'min:1', 'max:14'],
            'minat_topik_id' => ['nullable', 'integer', 'exists:minat_topiks,id'],
        ]);

        $mataKuliah->update($data);

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroyMataKuliah(MataKuliah $mataKuliah): RedirectResponse
    {
        MataKuliah::query()->whereKey($mataKuliah->id)->delete();

        return redirect()->route('kaprodi.master-data.index')->with('status', 'Mata kuliah berhasil dihapus.');
    }

    private function uniqueSlug(string $nama, ?int $exceptId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $counter = 2;

        while (
            MinatTopik::query()
                ->when($exceptId, fn ($query) => $query->whereKeyNot($exceptId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
