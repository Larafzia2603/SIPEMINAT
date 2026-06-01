# Sistem Rekomendasi Pemilihan Mata Kuliah Peminatan

Proyek ini merupakan sebuah aplikasi web bernama SIPEMINAT (Sistem Rekomendasi Pemilihan
Mata Kuliah Peminatan) yang bertujuan untuk membantu mahasiswa dalam memilih mata kuliah
peminatan yang paling relevan dengan minat dan kemampuan akademik mereka.

## Stack

- Laravel 13
- Laravel Breeze dengan Blade
- Vite + Tailwind CSS
- MySQL atau database relasional lain yang didukung Laravel

## Fitur awal

- Landing page untuk memperkenalkan aplikasi
- Autentikasi login dan register
- Dashboard per role: mahasiswa, dosen PA, kaprodi, dan dekan
- Form mahasiswa untuk input minat topik dan nilai prasyarat
- Mesin rekomendasi rule-based berbasis bobot skor
- Halaman dosen PA untuk melihat mahasiswa bimbingan dan override rekomendasi
- Audit log override dosen PA (alasan lama dan alasan baru)
- Halaman kaprodi untuk CRUD rule rekomendasi (tambah, edit, aktif/nonaktif, hapus)
- Halaman kaprodi untuk master data mata kuliah dan topik minat
- Halaman dekan untuk laporan ringkas popularitas rekomendasi + grafik
- Halaman mahasiswa untuk grafik skor rekomendasi dan jalur karir potensial
- Seed data awal untuk akun demo, relasi bimbingan, minat mahasiswa, nilai, dan rekomendasi awal

## Menjalankan proyek

1. Nyalakan Apache dan MySQL dari XAMPP.
2. Install dependency dan siapkan environment:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

3. Jalankan migrasi dan seed:

```bash
php artisan migrate:fresh --seed
```

4. Jalankan aplikasi:

```bash
npm run dev
php artisan serve
```

5. Buka aplikasi di `http://127.0.0.1:8000`.

## Menjalankan test

Konfigurasi PHPUnit di proyek ini menggunakan database MySQL `peminatan_db` agar cocok dengan setup XAMPP.

```bash
php artisan test
```

## Akun demo

Semua akun demo menggunakan password: `password`

- Mahasiswa: NIM `2204010001`
- Dosen PA: NIP `19870101001`
- Kaprodi: NIP `19791212002`
- Dekan: NIP `19650505003`

Catatan: Mahasiswa login memakai NIM/Stambuk, sedangkan dosen PA/kaprodi/dekan memakai NIP.

## Catatan pengembangan

- Root route diarahkan ke halaman landing khusus proyek.
- Breeze membutuhkan file `resources/js/bootstrap.js` untuk build frontend pada setup ini.
- Route dashboard sekarang berbasis role melalui middleware `role`.
- Fitur role workflow yang tersedia:
	- Mahasiswa: `/mahasiswa/profil-akademik`, `/mahasiswa/rekomendasi`
	- Dosen PA: `/dosen-pa/bimbingan`
	- Kaprodi master data: `/kaprodi/master-data`
	- Kaprodi: `/kaprodi/rules`
	- Dekan: `/dekan/laporan`
- Tersedia pengujian tambahan untuk alur rekomendasi di `tests/Feature/RecommendationFlowTest.php`.
