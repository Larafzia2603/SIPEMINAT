<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Rule Rekomendasi</h2>
                <p class="text-sm text-gray-600 mt-1">Atur aturan rekomendasi berbasis rule engine</p>
            </div>
            <span class="badge badge-primary">
                {{ $rules->count() }} Rules
            </span>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        <!-- Success Message -->
        @if (session('status'))
            <div class="card p-4 bg-green-50 border-green-200 animate-slide-down">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        <!-- Add New Rule Form -->
        <div class="card p-6 animate-slide-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Tambah Rule Baru</h3>
                    <p class="text-sm text-gray-600">Buat aturan rekomendasi baru</p>
                </div>
            </div>

            <form method="POST" action="{{ route('kaprodi.rules.store') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                
                <div class="md:col-span-2">
                    <x-input-label for="nama_rule" value="Nama Rule" />
                    <x-text-input id="nama_rule" name="nama_rule" type="text" class="mt-1 block w-full" placeholder="Contoh: Rule AI untuk nilai tinggi" required />
                </div>

                <div>
                    <x-input-label for="mata_kuliah_prasyarat_id" value="MK Prasyarat (opsional)" />
                    <select id="mata_kuliah_prasyarat_id" name="mata_kuliah_prasyarat_id" class="input mt-1">
                        <option value="">Pilih MK Prasyarat</option>
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="nilai_minimum" value="Nilai Minimum (opsional)" />
                    <select id="nilai_minimum" name="nilai_minimum" class="input mt-1">
                        <option value="">Pilih Nilai Minimum</option>
                        @foreach (['A', 'AB', 'B', 'BC', 'C', 'D', 'E'] as $nilai)
                            <option value="{{ $nilai }}">{{ $nilai }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="minat_topik_id" value="Minat Topik (opsional)" />
                    <select id="minat_topik_id" name="minat_topik_id" class="input mt-1">
                        <option value="">Pilih Minat Topik</option>
                        @foreach ($minatTopiks as $minat)
                            <option value="{{ $minat->id }}">{{ $minat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="mata_kuliah_rekomendasi_id" value="MK Rekomendasi" />
                    <select id="mata_kuliah_rekomendasi_id" name="mata_kuliah_rekomendasi_id" class="input mt-1" required>
                        <option value="">Pilih MK Rekomendasi</option>
                        @foreach ($mataKuliahs as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->kode }} - {{ $mk->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="bobot_skor" value="Bobot Skor" />
                    <x-text-input id="bobot_skor" name="bobot_skor" type="number" min="1" max="100" class="mt-1 block w-full" value="10" placeholder="1-100" required />
                </div>

                <div class="md:col-span-2">
                    <input type="hidden" name="is_active" value="1">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Rule
                    </button>
                </div>
            </form>
        </div>

        <!-- Rules List -->
        <div class="card p-6 animate-on-scroll">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Daftar Rule</h3>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rule</th>
                            <th>Filter</th>
                            <th>Rekomendasi</th>
                            <th>Bobot</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rules as $rule)
                            <tr>
                                <td>
                                    <p class="font-semibold text-gray-900">{{ $rule->nama_rule }}</p>
                                </td>
                                <td>
                                    <div class="space-y-1 text-sm">
                                        <p class="text-gray-700">
                                            <span class="font-medium">Minat:</span> 
                                            @if($rule->minatTopik)
                                                <span class="badge badge-primary text-xs">{{ $rule->minatTopik->nama }}</span>
                                            @else
                                                <span class="text-gray-500">Semua</span>
                                            @endif
                                        </p>
                                        <p class="text-gray-700">
                                            <span class="font-medium">MK Prasyarat:</span> {{ $rule->mataKuliahPrasyarat?->kode ?? '-' }}
                                        </p>
                                        <p class="text-gray-700">
                                            <span class="font-medium">Nilai Min:</span> 
                                            @if($rule->nilai_minimum)
                                                <span class="badge badge-warning text-xs">{{ $rule->nilai_minimum }}</span>
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-semibold text-gray-900">{{ $rule->mataKuliahRekomendasi?->kode }}</p>
                                    <p class="text-sm text-gray-600">{{ $rule->mataKuliahRekomendasi?->nama }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $rule->bobot_skor }}</span>
                                </td>
                                <td>
                                    @if ($rule->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('kaprodi.rules.edit', $rule) }}" class="btn btn-secondary text-xs py-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('kaprodi.rules.toggle', $rule) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline text-xs py-2">
                                                @if($rule->is_active)
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Nonaktifkan
                                                @else
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Aktifkan
                                                @endif
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('kaprodi.rules.destroy', $rule) }}" onsubmit="return confirm('Hapus rule ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary text-xs py-2 border-red-300 text-red-700 hover:bg-red-50">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <p class="text-gray-500">Belum ada rule rekomendasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
