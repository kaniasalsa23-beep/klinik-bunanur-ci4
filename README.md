# 🌸 Klinik Bunanur Care & Baby Spa – Portal Layanan Kebidanan Terpadu

> **Sistem Informasi Manajemen Layanan & Reservasi Medis Berbasis CodeIgniter 4 dengan Arsitektur Keamanan Siber Berlapis (*Defense-in-Depth*), Integrasi WhatsApp OTP Gateway, & Desain *Soft Pink Glassmorphism 3D***

[![CodeIgniter 4](https://img.shields.io/badge/Framework-CodeIgniter%204.7.3-EF4444.svg?style=flat-square&logo=codeigniter)](https://codeigniter.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4.svg?style=flat-square&logo=php)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-00758F.svg?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Security Standards](https://img.shields.io/badge/Security-OWASP%20ASVS%20Compliant-10B981.svg?style=flat-square&logo=shield)](https://owasp.org/)
[![WhatsApp Gateway](https://img.shields.io/badge/Gateway-Fonnte%20API-25D366.svg?style=flat-square&logo=whatsapp)](https://fonnte.com/)
[![Deployment](https://img.shields.io/badge/Deployment-InfinityFree%20HTTPS-0284C7.svg?style=flat-square)](https://klinikbunanur.infinityfreeapp.com)

---

## 📌 Informasi Project & Akses Publik

- **Judul Aplikasi:** Sistem Informasi Manajemen Layanan & Reservasi Klinik Bunanur (Baby Spa & Terapi Ibu dan Bayi)
- **URL Aplikasi Aktif (HTTPS):** [https://klinikbunanur.infinityfreeapp.com](https://klinikbunanur.infinityfreeapp.com)
- **URL Repository GitHub:** [https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git](https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git)
- **Mata Kuliah:** Cyber Security (Tugas Project Pengembangan & Pengamanan Aplikasi Web)
- **Kredensial Akun Uji Coba:**
  - **Role Admin (Bidan):** Username `bidan_bunanur` | Password `[Silakan hubungi administrator / lihat laporan akademik]`
  - **Role User (Pasien):** Username `[Akun Pasien Terdaftar]` | Password `[Password Pasien]` *(atau lakukan registrasi baru di `/register`)*

---

## 📖 Deskripsi Singkat Aplikasi

**Klinik Bunanur** adalah aplikasi web pelayanan kesehatan ibu dan anak yang menyediakan fasilitas pendaftaran pasien, reservasi antrean layanan (*Baby Spa, Pijat Laktasi, Imunisasi, ANC*), telekonsultasi chat dua arah, moderasi testimoni, serta rekapitulasi data kunjungan klinis.

Aplikasi ini dikembangkan menggunakan kerangka kerja **CodeIgniter 4** dengan pola arsitektur **MVC (Model-View-Controller)** dan menerapkan prinsip **Secure Coding** secara ketat untuk melindungi integritas rekam medis dan data pribadi pengguna (*Confidentiality, Integrity, Availability*).

---

## ✨ Fitur-Fitur Utama

### 1. Autentikasi & Pemulihan Akun (WhatsApp OTP Gateway)
- **Multi-Role Access Control:** Pemisahan hak akses antara Pasien (`/pasien/*`) dan Bidan/Admin (`/bidan/*`).
- **Zero-Trust Admin Registration:** Rute registrasi publik admin diblokir mutlak (`403 Forbidden`) untuk mencegah eskalasi hak istimewa (*Privilege Escalation*).
- **Lupa Kata Sandi via Real WhatsApp OTP:** Pengiriman kode OTP 6-digit rahasia secara *server-to-server* via cURL POST ke endpoint Fonnte API (`https://api.fonnte.com/send`).
- **Perlindungan Anti Brute-Force:** Masa berlaku OTP 5 menit (300 detik), batas salah maksimal 5 kali percobaan, dan tombol Kirim Ulang OTP dengan *cooldown* 60 detik.
- **Enkripsi Bcrypt Cost 12:** Penyimpanan kata sandi menggunakan `password_hash($password, PASSWORD_BCRYPT, ['cost' => 12])`.

### 2. Pengelolaan Data Layanan & Kunjungan (CRUD)
- Manajemen katalog layanan kebidanan & spa bayi (tambah, edit, status aktif/nonaktif).
- Pengajuan reservasi jadwal kunjungan online dengan validasi tanggal dan kuota harian.
- Konfirmasi, penyelesaian, dan pembatalan status kunjungan pasien oleh Bidan.
- Manajemen ulasan pasien dan galeri dokumentasi kegiatan klinik.

### 3. Konsultasi & Komunikasi Pasien
- Fitur tanya jawab medis interaktif antara pasien terdaftar dengan Bidan.
- Integrasi tombol WhatsApp resmi klinik dengan nomor dinamis terstandarisasi.

### 4. Pelaporan & Dashboard Monitoring
- Dashboard analitik Bidan dengan ringkasan metrik kunjungan, status antrean, dan grafik tren bulanan.
- Riwayat layanan pasien dan unduh tiket/bukti reservasi digital.

---

## 🛡️ Penerapan Keamanan Siber (Secure Coding)

1. **Pencegahan SQL Injection:** Seluruh manipulasi basis data menggunakan *Query Builder* dan *Prepared Statements* bawaan CodeIgniter 4 dengan *parameter binding*.
2. **Pencegahan XSS (Cross-Site Scripting):** Seluruh variabel keluaran di layer *View* disanitasi menggunakan fungsi `esc()`.
3. **Pencegahan CSRF (Cross-Site Request Forgery):** Proteksi CSRF diaktifkan secara global di seluruh formulir berbasis metode POST via token `csrf_field()`.
4. **Keamanan Sesi & Cookie:** Cookie sesi diamankan dengan atribut `HttpOnly`, `SameSite=Lax`, dan `Secure` (saat berjalan di HTTPS).
5. **Security Headers (Helmet Equivalent):** Mengaktifkan filter `SecurityHeadersFilter` yang menyuntikkan header:
   - `X-Frame-Options: DENY` (Anti Clickjacking)
   - `X-Content-Type-Options: nosniff` (Anti MIME-Sniffing)
   - `X-XSS-Protection: 1; mode=block`
   - `Referrer-Policy: strict-origin-when-cross-origin`
   - `Permissions-Policy: camera=(), microphone=(), geolocation=()`
   - `Content-Security-Policy (CSP)`
6. **Manajemen Rahasia (.env):** Kredensial basis data dan token WhatsApp Gateway (`FONNTE_TOKEN`) disimpan di `.env` yang dikecualikan dari repositori melalui `.gitignore`.

---

## 🛠️ Tech Stack & Spesifikasi Teknis

- **Bahasa Pemrograman:** PHP 8.2+
- **Web Framework:** CodeIgniter 4 (v4.7.3)
- **Database:** MySQL / MariaDB (Driver MySQLi)
- **Front-End Styling:** HTML5, CSS3 (*Custom Glassmorphism 3D*), Bootstrap 5, Boxicons, Chart.js
- **Integrasi API:** Fonnte WhatsApp Gateway REST API
- **Web Server & Hosting:** Apache dengan `mod_rewrite` aktif (.htaccess), dihosting di InfinityFree (SSL/TLS HTTPS)

---

## 🚀 Panduan Instalasi & Menjalankan di Lingkungan Lokal (XAMPP)

### 1. Kebutuhan Sistem
- XAMPP (Apache + MySQL / MariaDB + PHP 8.2+)
- Composer (v2.x)
- Git CLI

### 2. Langkah-Langkah Instalasi

```bash
# 1. Clone repositori ke htdocs XAMPP
cd C:\xampp\htdocs
git clone https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git klinik-ci4
cd klinik-ci4

# 2. Instal dependensi vendor via Composer
composer install

# 3. Buat file konfigurasi environment
copy .env.example .env
```

### 3. Konfigurasi Database & Token di `.env`
Buka file `.env` dan sesuaikan parameter berikut:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = klinik_db
database.default.username = root
database.default.password = 
database.default.port = 3306

# WhatsApp Gateway Fonnte
FONNTE_TOKEN = "your_fonnte_token_here"
WHATSAPP_GATEWAY_URL = "https://api.fonnte.com/send"
WHATSAPP_GATEWAY_TOKEN = "your_fonnte_token_here"
BIDAN_OFFICIAL_WHATSAPP = "6281224841377"
```

### 4. Eksekusi Migrasi & Seeder Database
Pastikan layanan MySQL di XAMPP telah aktif, kemudian jalankan:
```bash
# Jalankan migrasi tabel
php spark migrate

# Jalankan seeder akun resmi Bidan
php spark db:seed BidanWhatsAppSeeder
```

### 5. Menjalankan Server Lokal
```bash
php spark serve
```
Akses aplikasi melalui peramban web pada: `http://localhost:8080`

---

## 🤖 Transparansi Penggunaan AI Agent

Sesuai dengan ketentuan akademik mata kuliah Cyber Security:
- **Alat AI yang Digunakan:** Gemini (Google DeepMind)
- **Ruang Lingkup Bantuan AI:**
  1. Perancangan skema keamanan kriptografi OTP WhatsApp pada tabel `password_resets`.
  2. Implementasi filter keamanan HTTP Security Headers dan konfigurasi `.htaccess` kompatibel hosting.
  3. Penyusunan skenario uji coba penetrasi mandiri (*self-testing*) berbasis standar OWASP ASVS.
  4. Pembuatan dokumentasi teknis dan laporan akademik.
- **Contoh Prompt Utama:**
  > *"Rancang alur pemulihan kata sandi multi-role menggunakan verifikasi OTP WhatsApp via cURL server-to-server ke Fonnte API dengan pembatasan percobaan 5 kali dan hashing OTP di database."*
- **Verifikasi Mandiri oleh Mahasiswa:** Seluruh kode yang dihasilkan AI telah ditinjau baris demi baris, diuji sintaksnya (`php -l`), divalidasi aliran datanya melalui pengujian rute, dan diverifikasi secara manual pada lingkungan lokal maupun server produksi.

---

## 🧪 Ringkasan Hasil Self-Testing Keamanan

| No | Kategori Pengujian | Metode Uji | Hasil | Tindakan Perbaikan |
|---|---|---|---|---|
| 1 | **SQL Injection** | Injeksi `' OR '1'='1` pada login & query parameter | **Lolos** | Menggunakan CI4 Query Builder / Prepared Statements |
| 2 | **Cross-Site Scripting (XSS)** | Payload `<script>alert(1)</script>` pada testimoni & chat | **Lolos** | Output escaping menyeluruh dengan `esc()` |
| 3 | **Broken Access Control & IDOR** | Akses rute `/bidan/*` oleh pasien dan manipulasi ID | **Lolos** | Filter `BidanAuthFilter`, `PasienAuthFilter`, & validasi sesi |
| 4 | **Brute-Force & Session Security** | Percobaan OTP > 5 kali & fiksasi sesi saat logout | **Lolos** | Sesi otomatis terkunci saat attempts >= 5; token reset acak 64-karakter |
| 5 | **SSL/TLS & Security Headers** | Scan SSL Labs & pemeriksaan header via cURL | **Lolos** | Grade A SSL; Header HSTS, CSP, X-Frame-Options DENY aktif |
| 6 | **Secret & Git Hygiene** | Audit `git log` & verifikasi status `.gitignore` | **Lolos** | `.env` tidak ter-commit; `.env.example` hanya memuat placeholder |

---

## 📄 Lisensi & Hak Cipta
Project ini dikembangkan untuk pemenuhan tugas akademik mata kuliah Cyber Security. Seluruh hak cipta kode dan aset grafis dilindungi untuk keperluan pembelajaran.
