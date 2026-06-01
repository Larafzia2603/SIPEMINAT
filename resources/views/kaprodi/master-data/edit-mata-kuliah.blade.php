<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Mata Kuliah</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('kaprodi.master-data.mata-kuliah.update', $mataKuliah) }}" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="kode" value="Kode" />
                            <x-text-input id="kode" name="kode" type="text" class="mt-1 block w-full" :value="old('kode', $mataKuliah->kode)" required />
                        </div>
                        <div>
                            <x-input-label for="nama" value="Nama" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $mataKuliah->nama)" required />
                        </div>
                        <div>
                            <x-input-label for="sks" value="SKS" />
                            <x-text-input id="sks" name="sks" type="number" min="1" max="6" class="mt-1 block w-full" :value="old('sks', $mataKuliah->sks)" required />
                        </div>
                        <div>
                            <x-input-label for="semester_ideal" value="Semester Ideal" />
                            <x-text-input id="semester_ideal" name="semester_ideal" type="number" min="1" max="14" class="mt-1 block w-full" :value="old('semester_ideal', $mataKuliah->semester_ideal)" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="minat_topik_id" value="Minat Topik" />
                            <select id="minat_topik_id" name="minat_topik_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">-</option>
                                @foreach ($minatTopiks as $minat)
                                    <option value="{{ $minat->id }}" @selected(old('minat_topik_id', $mataKuliah->minat_topik_id) == $minat->id)>{{ $minat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2 flex items-center gap-3">
                            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Simpan</button>
                            <a href="{{ route('kaprodi.master-data.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
