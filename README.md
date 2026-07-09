# DISC Personality Test (disc_id)
Aplikasi Web Tes Kepribadian DISC Berbahasa Indonesia dengan Desain Modern & Responsif.

![screenshot](https://github.com/cahyadsn/disc_id/blob/master/img/home.png?raw=true)

## Pendahuluan

Alat tes **DISC** adalah sebuah instrumen evaluasi perilaku psikologis yang digunakan untuk memahami tipe-tipe perilaku dan gaya kepribadian seseorang. Teori ini pertama kali dikembangkan oleh **William Moulton Marston**. Dalam penerapannya di dunia profesional, bisnis, organisasi, maupun personal, alat tes ini sangat membantu dalam membuka wawasan terkait pola komunikasi dan interaksi antar-individu.

Model DISC membagi tipe perilaku manusia menjadi 4 dimensi utama:
*   **D**ominance (Dominasi): Fokus pada pencapaian hasil, kekuasaan, dan mengatasi tantangan. (Unsur ketegasan / *assertiveness*).
*   **I**nfluence (Pengaruh): Fokus pada hubungan interpersonal, komunikasi, dan memengaruhi orang lain. (Unsur komunikasi / *communication*).
*   **S**teadiness (Kemantapan): Fokus pada kerja sama, kesabaran, dan konsistensi. (Unsur kesabaran / *patience*).
*   **C**ompliance (Kepatuhan): Fokus pada struktur, detail, akurasi, dan kualitas. (Unsur struktur / *structure*).

Aplikasi ini dirancang untuk memudahkan pengisian tes secara mandiri secara digital serta menyajikan visualisasi hasil tes secara instan.

> [!WARNING]
> **PENTING**: Aplikasi ini dibuat untuk tujuan pembelajaran dan pengembangan diri (edukatif). Hasil dari aplikasi ini tidak boleh dijadikan sebagai satu-satunya acuan psikometri formal untuk rekrutmen profesional atau tujuan komersial resmi tanpa pengawasan psikolog berlisensi.

---

## Fitur Utama

*   **Antarmuka Glassmorphism Modern**: Tampilan visual yang futuristik, bersih, dan memanjakan mata dengan dukungan layout yang responsif di berbagai perangkat.
*   **Grafik Analisis SVG Interaktif**: Visualisasi otomatis berupa grafik garis (Line Chart) untuk 3 profil kepribadian utama:
    1.  *MOST (Mask/Public Self)*: Kepribadian yang ditampilkan di muka umum.
    2.  *LEAST (Core/Private Self)*: Kepribadian asli saat berada di bawah tekanan.
    3.  *CHANGE (Mirror/Perceived Self)*: Kepribadian asli yang tersembunyi / persepsi diri.
*   **Tally Box Instan**: Rekapitulasi perolehan skor dimensi D, I, S, dan C yang dihitung secara dinamis.
*   **Rekomendasi Profesi**: Menyertakan analisis singkat kecocokan karir (*Job Match*) berdasarkan pola grafik kepribadian yang terbentuk.

---

## Persyaratan Sistem

Untuk menjalankan aplikasi ini secara lokal, pastikan lingkungan server Anda memenuhi spesifikasi berikut:
*   **Web Server**: Apache / Nginx
*   **Bahasa Pemrogramam**: PHP 7.4 ke atas (direkomendasikan PHP 8.x)
*   **Database**: MySQL atau MariaDB

---

## Langkah Instalasi & Konfigurasi

1.  **Unduh Repositori**:
    Unduh berkas ZIP dari repositori ini atau lakukan kloning langsung:
    ```bash
    git clone https://github.com/cahyadsn/disc_id.git
    ```
2.  **Ekstrak Berkas**:
    Pindahkan atau ekstrak seluruh isi folder repositori ke direktori root web server Anda (misalnya `htdocs` pada XAMPP, `www` pada WampServer, atau folder aplikasi di Laragon).
3.  **Persiapkan Database**:
    *   Masuk ke basis data Anda (seperti phpMyAdmin atau klien database lainnya).
    *   Buat database baru bernama `disc`.
4.  **Impor Skema Database**:
    *   Impor berkas SQL yang berada di dalam folder `db/disc.sql` ke dalam database `disc` yang baru saja Anda buat.
5.  **Konfigurasi Koneksi**:
    *   Buka file [db.php](file:///D:/laragon/repo/dev/disc_id/inc/db.php) di dalam direktori `inc/`.
    *   Sesuaikan kredensial database (host, username, password, dan nama database) dengan konfigurasi server lokal Anda.
6.  **Jalankan Aplikasi**:
    *   Buka browser Anda dan akses aplikasi melalui alamat lokal (contoh: `http://localhost/disc_id`).

---

## Struktur Proyek

Berikut adalah gambaran struktur direktori dan file utama dalam proyek ini:
*   [css/](file:///D:/laragon/repo/dev/disc_id/css/) — Berisi file stylesheet [disc.css](file:///D:/laragon/repo/dev/disc_id/css/disc.css) untuk styling tampilan modern.
*   [db/](file:///D:/laragon/repo/dev/disc_id/db/) — Berisi skrip SQL [disc.sql](file:///D:/laragon/repo/dev/disc_id/db/disc.sql) untuk inisialisasi basis data.
*   [img/](file:///D:/laragon/repo/dev/disc_id/img/) — Menyimpan gambar aset atau tangkapan layar antarmuka.
*   [inc/](file:///D:/laragon/repo/dev/disc_id/inc/) — Berisi file-file konfigurasi backend PHP ([db.php](file:///D:/laragon/repo/dev/disc_id/inc/db.php) & [formula.php](file:///D:/laragon/repo/dev/disc_id/inc/formula.php)).
*   [js/](file:///D:/laragon/repo/dev/disc_id/js/) — Script Javascript untuk merender diagram SVG ([disc-chart.js](file:///D:/laragon/repo/dev/disc_id/js/disc-chart.js)).
*   [index.php](file:///D:/laragon/repo/dev/disc_id/index.php) — Halaman utama kuesioner tes kepribadian.
*   [result.php](file:///D:/laragon/repo/dev/disc_id/result.php) — Halaman pemrosesan skor dan penayangan hasil analisis kepribadian beserta grafik.

---

## Changelog

### [2026-07-09 15:06]
*   **Desain**: Memindahkan posisi tombol **PROSES** ke sebelah kanan bawah form tabel agar mengikuti alur pembacaan pengguna yang lebih natural.
*   **Tata Letak**: Mengubah penjajaran teks (*text-alignment*) pada kolom daftar **Gambaran Diri** menjadi rata kiri (*left-aligned*) agar teks deskripsi lebih rapi dan mudah dibaca secara vertikal.

---

## Disclaimer

*   Tampilan antarmuka dan data yang ada pada repositori ini mungkin memiliki perbedaan dengan demo web yang dirilis secara publik.
*   Data instrumen asli DiSC dilindungi oleh hak cipta (*proprietary*), sehingga data yang disediakan pada repositori publik ini bersifat alternatif atau modifikasi edukatif.
*   Formulasi, interpretasi, dan hasil analisis tes kepribadian ini berada dalam ranah ilmu psikologi. Sesuai kode etik, penggunaan secara klinis atau formal hanya diperuntukkan bagi profesional psikologi yang berwenang.

---

## Teknologi yang Digunakan

*   **HTML5 & CSS3**: Menggunakan styling CSS modern (Glassmorphism & variabel CSS).
*   **PHP**: Sebagai bahasa pemrosesan di sisi server (*server-side processing*).
*   **MySQL**: Untuk penyimpanan data deskripsi perilaku dan pola kepribadian.
*   **Vanilla JavaScript**: Digunakan untuk merender grafik garis SVG secara dinamis tanpa library berat pihak ketiga.

---

## Donasi

Jika Anda merasa proyek ini bermanfaat dan ingin memberikan dukungan kepada pengembang, Anda dapat menyalurkan donasi melalui:
*   **Transfer Bank Lokal**:
    *   Bank BCA Digital (Blu) (501): `000 576 776 186`
    *   Bank Jago (542): `5003 5796 1022`
    *   Bank Sinarmas (153): `005 462 4719`
    *   Bank Syariah Indonesia (BSI): `821-342-5550`
*   **PayPal**: [https://paypal.me/cahyadwiana](https://paypal.me/cahyadwiana)
*   **QRIS** (CAHYADSN ID1022183125288):

![Donasi via QRIS CAHYADSN](https://github.com/cahyadsn/wilayah/blob/master/docs/qr_code.cahyadsn.png?raw=true)

---

## Kontak

Untuk pertanyaan, saran, atau kolaborasi, silakan hubungi kami melalui saluran berikut:
*   **Facebook**: [Cahya DSN](https://m.facebook.com/cahya.dsn)
*   **Email**: cahyadsn@gmail.com
*   **Demo Aplikasi**: [psycho.cahyadsn.com/disc_id](http://psycho.cahyadsn.com/disc_id)
*   **Repositori**: [github.com/cahyadsn/disc_id](https://github.com/cahyadsn/disc_id)

---
*Lisensi Proyek: [MIT License](file:///D:/laragon/repo/dev/disc_id/LICENSE)*
