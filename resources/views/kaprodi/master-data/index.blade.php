<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Data Kaprodi</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-slate-900">Topik Minat</h3>
                        <form method="POST" action="{{ route('kaprodi.master-data.minat.store') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                            @csrf
                            <input name="nama" type="text" placeholder="Nama topik minat" class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Tambah</button>
                        </form>

                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Slug</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($minatTopiks as $minat)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-900">{{ $minat->nama }}</td>
                                            <td class="px-4 py-3 text-slate-700">{{ $minat->slug }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-wrap gap-2">
                                                    <a href="{{ route('kaprodi.master-data.minat.edit', $minat) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                                    <form method="POST" action="{{ route('kaprodi.master-data.minat.destroy', $minat) }}" onsubmit="return confirm('Hapus topik minat ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-slate-500">Belum ada topik minat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold text-slate-900">Mata Kuliah</h3>
                        <form method="POST" action="{{ route('kaprodi.master-data.mata-kuliah.store') }}" class="mt-4 grid gap-3 sm:grid-cols-2">
                            @csrf
                            <input name="kode" type="text" placeholder="Kode" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <input name="nama" type="text" placeholder="Nama mata kuliah" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <input name="sks" type="number" min="1" max="6" placeholder="SKS" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <input name="semester_ideal" type="number" min="1" max="14" placeholder="Semester ideal" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <select name="minat_topik_id" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:col-span-2">
                                <option value="">- Minat Topik -</option>
                                @foreach ($minatTopiks as $minat)
                                    <option value="{{ $minat->id }}">{{ $minat->nama }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 sm:col-span-2">Tambah</button>
                        </form>

                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Kode</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Minat</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($mataKuliahs as $mk)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-900">{{ $mk->kode }}</td>
                                            <td class="px-4 py-3 text-slate-700">{{ $mk->nama }}</td>
                                            <td class="px-4 py-3 text-slate-700">{{ $mk->minatTopik?->nama ?? '-' }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex flex-wrap gap-2">
                                                    <a href="{{ route('kaprodi.master-data.mata-kuliah.edit', $mk) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Edit</a>
                                                    <form method="POST" action="{{ route('kaprodi.master-data.mata-kuliah.destroy', $mk) }}" onsubmit="return confirm('Hapus mata kuliah ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada mata kuliah.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
