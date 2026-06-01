<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Profil Akademik</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola minat topik dan nilai mata kuliah prasyarat</p>
            </div>
            <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Lihat Rekomendasi
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        <!-- Info Alert -->
        <div class="card p-4 bg-primary-50 border-primary-200 animate-slide-up">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Informasi Penting</h3>
                    <p class="text-sm text-gray-700 mt-1">Isi minat topik dan nilai mata kuliah prasyarat untuk mendapatkan rekomendasi mata kuliah yang sesuai dengan profil akademik Anda.</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('mahasiswa.academic-profile.store') }}" class="space-y-6">
            @csrf

            <!-- Minat Topik Section -->
            <div class="card p-6 animate-on-scroll">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pilih Minat Topik</h3>
                        <p class="text-sm text-gray-600">Pilih topik peminatan yang Anda minati</p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($minatTopiks as $minat)
                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-500 hover:bg-primary-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50">
                            <input
                                type="checkbox"
                                name="minat_topik_ids[]"
                                value="{{ $minat->id }}"
                                @checked(in_array($minat->id, old('minat_topik_ids', $mahasiswa->minatTopiks->pluck('id')->all()), true))
                                class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                            >
                            <span class="font-medium text-gray-900">{{ $minat->nama }}</span>
                        </label>
                    @endforeach
                </div>
                @error('minat_topik_ids')
                    <p class="mt-3 text-sm text-red-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nilai Prasyarat Section -->
            <div class="card p-6 animate-on-scroll">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Input Nilai Prasyarat</h3>
                        <p class="text-sm text-gray-600">Masukkan nilai mata kuliah prasyarat Anda</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach ($mataKuliahs as $index => $mk)
                        @php
                            $nilaiLama = $nilaiMap->get($mk->id);
                        @endphp
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-primary-300 transition-colors duration-200">
                            <input type="hidden" name="nilai[{{ $index }}][mata_kuliah_id]" value="{{ $mk->id }}">
                            
                            <div class="grid gap-4 md:grid-cols-[2fr_1fr_1fr]">
                                <!-- Mata Kuliah Info -->
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $mk->kode }}</p>
                                        <p class="text-sm text-gray-600">{{ $mk->nama }}</p>
                                        @if($mk->semester_ideal)
                                            <p class="text-xs text-gray-500 mt-1">Semester: {{ $mk->semester_ideal }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Nilai Huruf -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Huruf</label>
                                    <select name="nilai[{{ $index }}][nilai_huruf]" class="input">
                                        @foreach (['A', 'AB', 'B', 'BC', 'C', 'D', 'E'] as $opsiNilai)
                                            <option value="{{ $opsiNilai }}" @selected(old("nilai.$index.nilai_huruf", $nilaiLama?->nilai_huruf ?? 'B') === $opsiNilai)>{{ $opsiNilai }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Nilai Angka -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Angka</label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="4"
                                        name="nilai[{{ $index }}][nilai_angka]"
                                        value="{{ old("nilai.$index.nilai_angka", $nilaiLama?->nilai_angka) }}"
                                        class="input"
                                        placeholder="0.00 - 4.00"
                                    >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 sm:justify-end animate-on-scroll">
                <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="btn btn-secondary justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Rekomendasi
                </a>
                <button type="submit" class="btn btn-primary justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Simpan dan Hitung
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
