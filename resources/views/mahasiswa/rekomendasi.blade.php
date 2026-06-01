<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Hasil Rekomendasi</h2>
                <p class="text-sm text-gray-600 mt-1">Rekomendasi mata kuliah berdasarkan profil akademik Anda</p>
            </div>
            <form method="POST" action="{{ route('mahasiswa.rekomendasi.regenerate') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Hitung Ulang
                </button>
            </form>
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

        <!-- Minat Info -->
        <div class="card p-6 bg-gradient-to-br from-primary-50 to-primary-100 border-primary-200 animate-slide-up">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1">Minat Topik Aktif</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($mahasiswa->minatTopiks as $minat)
                            <span class="badge badge-primary">{{ $minat->nama }}</span>
                        @empty
                            <span class="text-gray-600">Belum ada minat topik dipilih</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekomendasi Table -->
        <div class="card p-6 animate-on-scroll">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Rekomendasi Mata Kuliah</h3>
            
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Skor</th>
                            <th>Alasan</th>
                            <th>Override</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekomendasis as $rekomendasi)
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
                                        <span class="badge badge-warning">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            {{ $rekomendasi->overrideBy?->name ?? 'Dosen PA' }}
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Sistem
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($rekomendasi->id, $pilihanIds, true))
                                        <form method="POST" action="{{ route('mahasiswa.rekomendasi.unchoose', $rekomendasi->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary text-sm py-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Batal
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('mahasiswa.rekomendasi.choose', $rekomendasi->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary text-sm py-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Pilih
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500">Belum ada rekomendasi. Isi profil akademik terlebih dulu.</p>
                                    <a href="{{ route('mahasiswa.academic-profile.index') }}" class="btn btn-primary mt-4 inline-flex">
                                        Isi Profil Akademik
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Charts and Career Paths -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart -->
            <div class="card p-6 animate-on-scroll">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Skor Rekomendasi</h3>
                <div class="h-72">
                    <canvas id="mahasiswaRekomendasiChart"></canvas>
                </div>
            </div>

            <!-- Career Paths -->
            <div class="card p-6 animate-on-scroll">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Jalur Karir Potensial</h3>
                </div>
                <ul class="space-y-3">
                    @forelse ($careerPaths as $career)
                        <li class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                            <svg class="w-5 h-5 text-primary-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-700">{{ $career }}</span>
                        </li>
                    @empty
                        <li class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Belum ada jalur karir. Pilih minat topik terlebih dulu.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Pilihan Final -->
        <div class="card p-6 animate-on-scroll">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Pilihan Mata Kuliah Final</h3>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekomendasis->whereIn('id', $pilihanIds) as $selected)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $selected->mataKuliah->kode }}</p>
                                            <p class="text-sm text-gray-600">{{ $selected->mataKuliah->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-success">Dipilih</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-8 text-gray-500">
                                    Belum ada pilihan final. Pilih mata kuliah dari daftar rekomendasi di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Override History -->
        <div class="card p-6 animate-on-scroll">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Override Dosen PA</h3>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Dosen PA</th>
                            <th>Alasan Sebelumnya</th>
                            <th>Alasan Baru</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $overrideLogs = $rekomendasis
                                ->flatMap(fn ($item) => $item->overrideLogs->map(fn ($log) => ['mk' => $item->mataKuliah, 'log' => $log]))
                                ->sortByDesc(fn ($row) => $row['log']->created_at)
                                ->values();
                        @endphp

                        @forelse ($overrideLogs as $row)
                            <tr>
                                <td>
                                    <p class="font-semibold text-gray-900">{{ $row['mk']->kode }}</p>
                                    <p class="text-sm text-gray-600">{{ $row['mk']->nama }}</p>
                                </td>
                                <td>{{ $row['log']->dosenPa?->name ?? '-' }}</td>
                                <td class="text-sm text-gray-700">{{ $row['log']->alasan_sebelumnya ?: '-' }}</td>
                                <td class="text-sm text-gray-700">{{ $row['log']->alasan_baru }}</td>
                                <td class="text-sm text-gray-600">{{ $row['log']->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    Belum ada riwayat override dari dosen PA.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        const mahasiswaChartEl = document.getElementById('mahasiswaRekomendasiChart');
        if (mahasiswaChartEl) {
            const labels = @json($chartLabels);
            const values = @json($chartValues);

            new Chart(mahasiswaChartEl, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Skor Rekomendasi',
                        data: values,
                        backgroundColor: '#2563eb',
                        borderRadius: 8,
                        barThickness: 40,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            borderRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                },
            });
        }
    </script>
</x-app-layout>
