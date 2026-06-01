<?php

namespace App\Services;

use App\Models\RekomendasiMataKuliah;
use App\Models\RekomendasiRule;
use App\Models\User;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * @return Collection<int, RekomendasiMataKuliah>
     */
    public function generateForMahasiswa(User $mahasiswa): Collection
    {
        $nilaiPerMataKuliah = $mahasiswa->nilaiPrasyaratMahasiswas
            ->mapWithKeys(fn ($item) => [$item->mata_kuliah_id => strtoupper($item->nilai_huruf)])
            ->all();

        $minatIds = $mahasiswa->minatTopiks->pluck('id')->all();

        $rules = RekomendasiRule::query()
            ->with('mataKuliahRekomendasi')
            ->where('is_active', true)
            ->get();

        $evaluated = [];

        foreach ($rules as $rule) {
            if (! $this->passesMinatFilter($rule->minat_topik_id, $minatIds)) {
                continue;
            }

            if (! $this->passesNilaiFilter($rule->mata_kuliah_prasyarat_id, $rule->nilai_minimum, $nilaiPerMataKuliah)) {
                continue;
            }

            $mkId = $rule->mata_kuliah_rekomendasi_id;

            if (! isset($evaluated[$mkId])) {
                $evaluated[$mkId] = [
                    'skor' => 0,
                    'rule_id' => $rule->id,
                    'alasan' => [],
                ];
            }

            $evaluated[$mkId]['skor'] += $rule->bobot_skor;
            $evaluated[$mkId]['rule_id'] = $evaluated[$mkId]['rule_id'] ?? $rule->id;
            $evaluated[$mkId]['alasan'][] = $rule->nama_rule;
        }

        RekomendasiMataKuliah::query()->where('mahasiswa_id', $mahasiswa->id)->delete();

        $created = collect();

        foreach ($evaluated as $mkId => $item) {
            $created->push(RekomendasiMataKuliah::query()->create([
                'mahasiswa_id' => $mahasiswa->id,
                'mata_kuliah_id' => $mkId,
                'rule_id' => $item['rule_id'],
                'skor' => $item['skor'],
                'alasan' => implode('; ', $item['alasan']),
                'is_overridden' => false,
            ]));
        }

        return $created->sortByDesc('skor')->values();
    }

    /**
     * @param array<int, int> $minatIds
     */
    private function passesMinatFilter(?int $ruleMinatId, array $minatIds): bool
    {
        if ($ruleMinatId === null) {
            return true;
        }

        return in_array($ruleMinatId, $minatIds, true);
    }

    /**
     * @param array<int, string> $nilaiPerMataKuliah
     */
    private function passesNilaiFilter(?int $mkPrasyaratId, ?string $nilaiMinimum, array $nilaiPerMataKuliah): bool
    {
        if ($mkPrasyaratId === null || $nilaiMinimum === null) {
            return true;
        }

        $nilaiMahasiswa = $nilaiPerMataKuliah[$mkPrasyaratId] ?? null;

        if ($nilaiMahasiswa === null) {
            return false;
        }

        return $this->gradeRank($nilaiMahasiswa) >= $this->gradeRank($nilaiMinimum);
    }

    private function gradeRank(string $nilai): int
    {
        $map = [
            'A' => 5,
            'AB' => 4,
            'B' => 3,
            'BC' => 2,
            'C' => 1,
            'D' => 0,
            'E' => -1,
        ];

        return $map[strtoupper($nilai)] ?? -1;
    }
}
