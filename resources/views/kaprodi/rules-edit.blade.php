<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Rule Rekomendasi</h2>
                <p class="text-sm text-gray-600 mt-1">Ubah aturan rekomendasi yang sudah ada</p>
            </div>
            <a href="{{ route('kaprodi.rules.index') }}" class="btn btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">
        <div class="card p-6 animate-slide-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Form Edit Rule</h3>
                    <p class="text-sm text-gray-600">Perbarui informasi rule rekomendasi</p>
                </div>
            </div>

            <form method="POST" action="{{ route('kaprodi.rules.update', $rule) }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div class="md:col-span-2">
                    <x-input-label for="nama_rule" value="Nama Rule" />
                    <x-text-input id="nama_rule" name="nama_rule" type="text" class="mt-1 block w-full" :value="old('nama_rule', $rule->nama_rule)" required />
                </div>

                <div>
                    <x-input-label for="mata_kuliah_prasyarat_id" value="MK Prasyarat (opsional)" />
                    <select id="mata_kuliah_prasyarat_id" name="mata_kuliah_prasyarat_id" class="input mt-1">
                        <option value="">Pilih MK Prasyarat</option>
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" @selected((int) old('mata_kuliah_prasyarat_id', (int) $rule->mata_kuliah_prasyarat_id) === $mk->id)>
                                {{ $mk->kode }} - {{ $mk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="nilai_minimum" value="Nilai Minimum (opsional)" />
                    <select id="nilai_minimum" name="nilai_minimum" class="input mt-1">
                        <option value="">Pilih Nilai Minimum</option>
                        @foreach (['A', 'AB', 'B', 'BC', 'C', 'D', 'E'] as $nilai)
                            <option value="{{ $nilai }}" @selected(old('nilai_minimum', $rule->nilai_minimum) === $nilai)>{{ $nilai }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="minat_topik_id" value="Minat Topik (opsional)" />
                    <select id="minat_topik_id" name="minat_topik_id" class="input mt-1">
                        <option value="">Pilih Minat Topik</option>
                        @foreach ($minatTopiks as $minat)
                            <option value="{{ $minat->id }}" @selected((int) old('minat_topik_id', (int) $rule->minat_topik_id) === $minat->id)>
                                {{ $minat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="mata_kuliah_rekomendasi_id" value="MK Rekomendasi" />
                    <select id="mata_kuliah_rekomendasi_id" name="mata_kuliah_rekomendasi_id" class="input mt-1" required>
                        <option value="">Pilih MK Rekomendasi</option>
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}" @selected((int) old('mata_kuliah_rekomendasi_id', (int) $rule->mata_kuliah_rekomendasi_id) === $mk->id)>
                                {{ $mk->kode }} - {{ $mk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="bobot_skor" value="Bobot Skor" />
                    <x-text-input id="bobot_skor" name="bobot_skor" type="number" min="1" max="100" class="mt-1 block w-full" :value="old('bobot_skor', $rule->bobot_skor)" required />
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500" @checked((bool) old('is_active', $rule->is_active))>
                        <span class="text-sm font-medium text-gray-700">Rule aktif</span>
                    </label>
                </div>

                <div class="md:col-span-2 flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('kaprodi.rules.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
