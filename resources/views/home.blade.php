<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('build/assets/app-CEsRRwPV.css') }}">
        <script type="module" src="{{ asset('build/assets/app-MfOIQmzT.js') }}"></script>

        <title>{{ config('app.name', 'Laravel') }} - Sistem Rekomendasi Peminatan</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.16),_transparent_34%),radial-gradient(circle_at_top_right,_rgba(14,165,233,0.12),_transparent_28%),radial-gradient(circle_at_bottom_right,_rgba(59,130,246,0.08),_transparent_22%),linear-gradient(180deg,_#eff6ff_0%,_#f8fafc_42%,_#ffffff_100%)]"></div>
            <div class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-6 py-6 lg:px-10 lg:py-8">
                <header class="flex flex-col gap-4 rounded-3xl border border-white/70 bg-white/70 px-5 py-4 shadow-soft backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-primary text-white shadow-soft">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-primary-600">SIPEMINAT</p>
                            <h1 class="mt-1 text-lg font-bold text-slate-900 sm:text-xl">Sistem Rekomendasi Pemilihan Mata Kuliah Peminatan</h1>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary rounded-full px-5 py-2.5 text-sm">Ke Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-secondary rounded-full px-5 py-2.5 text-sm">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary rounded-full px-5 py-2.5 text-sm">Daftar</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </header>

                <main class="grid flex-1 items-center gap-10 py-8 lg:grid-cols-[1.05fr_0.95fr] lg:gap-14 lg:py-12">
                    <section class="space-y-8 animate-slide-up">
                        <div class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-primary-50 px-4 py-2 text-sm font-medium text-primary-700 shadow-sm">
                            <span class="h-2 w-2 rounded-full bg-primary-500"></span>
                            Mulai dari nilai prasyarat, minat topik, sampai rekomendasi MK lanjutan.
                        </div>

                        <div class="space-y-5">
                            <h2 class="max-w-3xl text-4xl font-black tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                                Bantu mahasiswa memilih peminatan yang paling relevan.
                            </h2>
                            <p class="max-w-2xl text-lg leading-8 text-slate-600 sm:text-xl">
                                Website ini menyiapkan alur rekomendasi berbasis aturan sederhana, dashboard multi-role, dan ruang untuk grafik jalur karir serta statistik peminatan per prodi.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="btn btn-primary rounded-full px-6 py-3 text-base shadow-soft">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-secondary rounded-full px-6 py-3 text-base">
                                Masuk ke Sistem
                            </a>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="stat-card rounded-2xl bg-white/80 backdrop-blur">
                                <p class="text-sm font-medium text-slate-500">Rekomendasi</p>
                                <p class="mt-2 text-2xl font-bold text-slate-950">Rule-based</p>
                                <p class="mt-1 text-sm text-slate-600">Berbasis nilai dan minat topik.</p>
                            </div>
                            <div class="stat-card rounded-2xl bg-white/80 backdrop-blur">
                                <p class="text-sm font-medium text-slate-500">Role</p>
                                <p class="mt-2 text-2xl font-bold text-slate-950">4 level user</p>
                                <p class="mt-1 text-sm text-slate-600">Mahasiswa, dosen PA, kaprodi, dekan.</p>
                            </div>
                            <div class="stat-card rounded-2xl bg-white/80 backdrop-blur">
                                <p class="text-sm font-medium text-slate-500">Visual</p>
                                <p class="mt-2 text-2xl font-bold text-slate-950">Grafik jalur karir</p>
                                <p class="mt-1 text-sm text-slate-600">Ruang untuk analitik dan laporan prodi.</p>
                            </div>
                        </div>
                    </section>

                    <aside class="animate-slide-up lg:justify-self-end">
                        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_24px_80px_rgba(15,23,42,0.10)] sm:p-8">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-primary-600">Preview Alur</p>
                                    <h3 class="mt-2 text-2xl font-bold text-slate-950">Tahap awal implementasi</h3>
                                </div>
                            </div>

                            <div class="mt-6 grid gap-4">
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-200 hover:bg-primary-50">
                                    <p class="text-sm font-medium text-slate-500">1. Mahasiswa</p>
                                    <p class="mt-1 text-base font-semibold text-slate-900">Input nilai prasyarat dan minat topik.</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-200 hover:bg-primary-50">
                                    <p class="text-sm font-medium text-slate-500">2. Sistem</p>
                                    <p class="mt-1 text-base font-semibold text-slate-900">Hitung rekomendasi mata kuliah peminatan.</p>
                                </div>
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition-colors duration-200 hover:bg-primary-50">
                                    <p class="text-sm font-medium text-slate-500">3. Dosen dan Kaprodi</p>
                                    <p class="mt-1 text-base font-semibold text-slate-900">Pantau, override, dan analisis statistik minat.</p>
                                </div>
                            </div>
                        </div>
                    </aside>
                </main>

                <footer class="border-t border-slate-200/80 py-6 text-sm text-slate-500">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <p>&copy; {{ date('Y') }} Sistem Peminatan Mata Kuliah. All rights reserved.</p>
                        <p>SIPEMINAT for recommendation and academic guidance.</p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>