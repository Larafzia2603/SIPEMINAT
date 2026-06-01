<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kaprodi\StoreRuleRequest;
use App\Http\Requests\Kaprodi\UpdateRuleRequest;
use App\Models\MataKuliah;
use App\Models\MinatTopik;
use App\Models\RekomendasiRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RuleController extends Controller
{
    public function index(): View
    {
        return view('kaprodi.rules', [
            'rules' => RekomendasiRule::query()->with(['minatTopik', 'mataKuliahPrasyarat', 'mataKuliahRekomendasi'])->latest()->get(),
            'mataKuliahs' => MataKuliah::query()->orderBy('nama', 'asc')->get(),
            'minatTopiks' => MinatTopik::query()->orderBy('nama', 'asc')->get(),
        ]);
    }

    public function store(StoreRuleRequest $request): RedirectResponse
    {
        RekomendasiRule::query()->create($request->validated());

        return redirect()->route('kaprodi.rules.index')->with('status', 'Rule rekomendasi berhasil ditambahkan.');
    }

    public function edit(RekomendasiRule $rule): View
    {
        return view('kaprodi.rules-edit', [
            'rule' => $rule,
            'mataKuliahs' => MataKuliah::query()->orderBy('nama', 'asc')->get(),
            'minatTopiks' => MinatTopik::query()->orderBy('nama', 'asc')->get(),
        ]);
    }

    public function update(UpdateRuleRequest $request, RekomendasiRule $rule): RedirectResponse
    {
        $rule->update($request->validated());

        return redirect()->route('kaprodi.rules.index')->with('status', 'Rule rekomendasi berhasil diperbarui.');
    }

    public function destroy(RekomendasiRule $rule): RedirectResponse
    {
        RekomendasiRule::query()->whereKey($rule->id)->delete();

        return redirect()->route('kaprodi.rules.index')->with('status', 'Rule rekomendasi berhasil dihapus.');
    }

    public function toggle(RekomendasiRule $rule): RedirectResponse
    {
        $rule->update([
            'is_active' => ! $rule->is_active,
        ]);

        return redirect()->route('kaprodi.rules.index')->with('status', 'Status rule berhasil diperbarui.');
    }
}
