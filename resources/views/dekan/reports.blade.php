<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Ringkas</h2>
                <p class="text-sm text-gray-600 mt-1">Overview dan analisis data peminatan fakultas</p>
            </div>
            <button onclick="window.print()" class="btn btn-outline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan
            </button>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-3 animate-slide-up">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Topik Minat</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMinat }}</p>
                        <p class="text-xs text-gray-500 mt-1">Topik peminatan tersedia</p>
                    </div>
                    <div class="icon-container icon-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Mata Kuliah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMataKuliah }}</p>
                        <p class="text-xs text-gray-500 mt-1">Mata kuliah peminatan</p>
                    </div>
                    <div class="icon-container icon-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Rekomendasi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalRekomendasi }}</p>
                        <p class="text-xs text-gray-500 mt-1">Rekomendasi tercatat</p>
                    </div>
                    <div class="icon-container icon-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa per Prodi -->
        <div class="card p-6 animate-on-scroll">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Jumlah Mahasiswa per Prodi</h3>
                    <p class="text-sm text-gray-600">Distribusi mahasiswa berdasarkan program studi</p>
                </div>
            </div>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Program Studi</th>
                            <th>Total Mahasiswa</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalMahasiswa = $prodiReports->sum('total');
                        @endphp
                        @forelse ($prodiReports as $row)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-gray-900">{{ $row->prodi }}</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary text-lg">{{ $row->total }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $totalMahasiswa > 0 ? ($row->total / $totalMahasiswa * 100) : 0 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $totalMahasiswa > 0 ? number_format($row->total / $totalMahasiswa * 100, 1) : 0 }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500">Belum ada data prodi mahasiswa.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popularitas Mata Kuliah -->
        <div class="card p-6 animate-on-scroll">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Popularitas Mata Kuliah Peminatan</h3>
                    <p class="text-sm text-gray-600">Mata kuliah yang paling banyak direkomendasikan</p>
                </div>
            </div>

            <!-- Chart -->
            <div class="mb-6 h-80 bg-gray-50 rounded-xl p-4">
                <canvas id="dekanPopularitasChart"></canvas>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Total Direkomendasikan</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($popularMataKuliah as $index => $row)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center font-bold text-primary-600">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $row->mataKuliah?->kode }}</p>
                                            <p class="text-sm text-gray-600">{{ $row->mataKuliah?->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary text-lg">{{ $row->total }}</span>
                                </td>
                                <td>
                                    @if($index === 0)
                                        <span class="badge badge-success">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                            </svg>
                                            Trending
                                        </span>
                                    @else
                                        <span class="badge badge-primary">Popular</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500">Belum ada data rekomendasi.</p>
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
        const dekanChartEl = document.getElementById('dekanPopularitasChart');
        if (dekanChartEl) {
            const labels = @json($chartLabels);
            const values = @json($chartValues);

            new Chart(dekanChartEl, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Total Direkomendasikan',
                        data: values,
                        backgroundColor: '#2563eb',
                        borderRadius: 8,
                        barThickness: 50,
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
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                            grid: {
                                color: '#f3f4f6'
                            }
                        },
                        x: {
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
