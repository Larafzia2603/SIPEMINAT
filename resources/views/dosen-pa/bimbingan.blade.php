<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Mahasiswa Bimbingan</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola dan override rekomendasi mahasiswa bimbingan Anda</p>
            </div>
            <span class="badge badge-primary">
                {{ count($mahasiswas) }} Mahasiswa
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

        <!-- Info Alert -->
        <div class="card p-4 bg-primary-50 border-primary-200 animate-slide-up">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Informasi Override</h3>
                    <p class="text-sm text-gray-700 mt-1">Anda dapat mengubah rekomendasi sistem jika diperlukan. Pastikan memberikan alasan yang jelas untuk setiap override.</p>
                </div>
            </div>
        </div>

        <!-- Mahasiswa List -->
        @forelse ($mahasiswas as $mahasiswa)
            <div class="card p-6 animate-on-scroll">
                <!-- Mahasiswa Header -->
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($mahasiswa->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $mahasiswa->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $mahasiswa->email }}</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @forelse($mahasiswa->minatTopiks as $minat)
                                    <span class="badge badge-primary text-xs">{{ $minat->nama }}</span>
                                @empty
                                    <span class="text-xs text-gray-500">Belum memilih minat</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="badge badge-success">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $mahasiswa->rekomendasiMataKuliahs->count() }} Rekomendasi
                        </span>
                    </div>
                </div>

                <!-- Rekomendasi Table -->
                <div class="mb-6">
                    <h4 class="text-base font-semibold text-gray-900 mb-4">Daftar Rekomendasi</h4>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Skor</th>
                                    <th>Alasan</th>
                                    <th>Override</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mahasiswa->rekomendasiMataKuliahs->sortByDesc('skor') as $rekomendasi)
                                    <tr>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $rekomendasi->mataKuliah->kode }}</p>
                                                    <p class="text-sm text-gray-600">{{ $rekomendasi->mataKuliah->nama }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary text-lg">{{ $rekomendasi->skor }}</span>
                                        </td>
                                        <td>
                                            <p class="text-sm text-gray-700">{{ $rekomendasi->alasan ?: '-' }}</p>
                                        </td>
                                        <td>
                                            @if ($rekomendasi->is_overridden)
                                                <div class="flex flex-col gap-2">
                                                    <form method="POST" action="{{ route('dosen-pa.bimbingan.override.update', $rekomendasi) }}" class="flex flex-col sm:flex-row gap-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input 
                                                            type="text" 
                                                            name="alasan" 
                                                            value="{{ $rekomendasi->alasan }}"
                                                            placeholder="Alasan override..." 
                                                            class="input text-sm flex-1"
                                                            required
                                                        >
                                                        <button type="submit" class="btn btn-primary text-sm py-2 whitespace-nowrap">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Update
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <form method="POST" action="{{ route('dosen-pa.bimbingan.override') }}" class="flex flex-col sm:flex-row gap-2">
                                                    @csrf
                                                    <input type="hidden" name="rekomendasi_id" value="{{ $rekomendasi->id }}">
                                                    <input 
                                                        type="text" 
                                                        name="alasan" 
                                                        placeholder="Alasan override..." 
                                                        class="input text-sm flex-1"
                                                        required
                                                    >
                                                    <button type="submit" class="btn btn-primary text-sm py-2 whitespace-nowrap">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Override
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-gray-500">
                                            Belum ada rekomendasi untuk mahasiswa ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Override History -->
                <div>
                    <h4 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Override
                    </h4>
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Alasan Sebelumnya</th>
                                    <th>Alasan Baru</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $logs = $mahasiswa->rekomendasiMataKuliahs
                                        ->flatMap(fn ($item) => $item->overrideLogs->map(fn ($log) => ['mk' => $item->mataKuliah, 'log' => $log]))
                                        ->sortByDesc(fn ($row) => $row['log']->created_at)
                                        ->values();
                                @endphp

                                @forelse ($logs as $row)
                                    <tr>
                                        <td>
                                            <p class="font-semibold text-gray-900">{{ $row['mk']->kode }}</p>
                                            <p class="text-sm text-gray-600">{{ $row['mk']->nama }}</p>
                                        </td>
                                        <td class="text-sm text-gray-700">{{ $row['log']->alasan_sebelumnya ?: '-' }}</td>
                                        <td class="text-sm text-gray-700">{{ $row['log']->alasan_baru }}</td>
                                        <td class="text-sm text-gray-600">{{ $row['log']->created_at?->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="flex flex-col gap-2">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <form method="POST" action="{{ route('dosen-pa.bimbingan.override-log.update', $row['log']) }}" class="flex flex-1 min-w-[200px] gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="text"
                                                        name="alasan"
                                                        value="{{ $row['log']->alasan_baru }}"
                                                        class="input text-sm flex-1"
                                                        required
                                                    >
                                                    <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-primary-200 bg-primary-50 p-2 text-primary-600 hover:bg-primary-100" title="Update alasan" aria-label="Update alasan">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                    <form method="POST" action="{{ route('dosen-pa.bimbingan.override-log.delete', $row['log']) }}" onsubmit="return confirm('Hapus riwayat override ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 p-2 text-red-600 hover:bg-red-100" title="Hapus riwayat" aria-label="Hapus riwayat">
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-500">
                                            Belum ada riwayat override untuk mahasiswa ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center animate-on-scroll">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Mahasiswa Bimbingan</h3>
                <p class="text-gray-600">Belum ada mahasiswa yang terhubung sebagai mahasiswa bimbingan Anda.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
