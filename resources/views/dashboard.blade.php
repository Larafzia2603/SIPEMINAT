<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-600">Ringkasan awal untuk mahasiswa, dosen PA, kaprodi, dan dekan.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Mahasiswa</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Isi nilai dan minat</p>
                            <p class="mt-1 text-sm text-slate-600">Siapkan data dasar untuk rekomendasi MK.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Dosen PA</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Monitor pilihan</p>
                            <p class="mt-1 text-sm text-slate-600">Tinjau dan override rekomendasi bila perlu.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Kaprodi</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Analisis statistik</p>
                            <p class="mt-1 text-sm text-slate-600">Lihat minat per MK dan ubah rule.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Dekan</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">Laporan prodi</p>
                            <p class="mt-1 text-sm text-slate-600">Pantau popularitas peminatan secara umum.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-slate-900">Langkah berikutnya</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li>1. Tambahkan tabel mahasiswa, mata kuliah, minat, dan rekomendasi.</li>
                        <li>2. Buat service untuk rule-based recommendation.</li>
                        <li>3. Hubungkan role user dengan dashboard yang berbeda.</li>
                        <li>4. Tambahkan grafik jalur karir dan statistik peminatan.</li>
                    </ul>
                </div>

                <div class="rounded-2xl bg-slate-900 p-6 text-slate-100 shadow-sm ring-1 ring-slate-800">
                    <p class="text-sm uppercase tracking-[0.3em] text-cyan-300">Status</p>
                    <h3 class="mt-3 text-2xl font-bold">Starter project siap dikembangkan.</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-300">
                        Auth scaffold sudah terpasang, root page sudah diganti, dan struktur awal siap untuk fitur rekomendasi peminatan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
