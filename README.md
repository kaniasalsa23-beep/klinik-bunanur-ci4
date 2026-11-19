# 🌸 Klinik Bunanur Care & Baby Spa – Portal Layanan Kebidanan Terpadu

> **Sistem Informasi Manajemen Layanan Medis & Reservasi Kebidanan Berbasis CodeIgniter 4 dengan Arsitektur Keamanan Siber Berlapis (*Defense-in-Depth / OWASP ASVS Compliant*), Real-Time Presence Sync, Mobile-First Responsive UI, Integrasi WhatsApp OTP Gateway, & Desain *Soft Pink Glassmorphism 3D***

[![CodeIgniter 4](https://img.shields.io/badge/Framework-CodeIgniter%204.7.3-EF4444.svg?style=flat-square&logo=codeigniter)](https://codeigniter.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4.svg?style=flat-square&logo=php)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-00758F.svg?style=flat-square&logo=mysql)](https://www.mysql.com/)
[![Security Standards](https://img.shields.io/badge/Security-OWASP%20ASVS%20Compliant-10B981.svg?style=flat-square&logo=shield)](https://owasp.org/)
[![WhatsApp Gateway](https://img.shields.io/badge/Gateway-Fonnte%20API-25D366.svg?style=flat-square&logo=whatsapp)](https://fonnte.com/)
[![Deployment](https://img.shields.io/badge/Deployment-InfinityFree%20HTTPS-0284C7.svg?style=flat-square)](https://klinik-bunanur.infinityfreeapp.com/)

---

## 📌 Informasi Project & Akses Publik

| Kanal / Layanan | Tautan Akses Langsung | Keterangan |
|---|---|---|
| 🌐 **URL Aplikasi Utama (HTTPS)** | [https://klinik-bunanur.infinityfreeapp.com/](https://klinik-bunanur.infinityfreeapp.com/) | Halaman Utama / Landing Page Profil Klinik & Katalog Layanan |
| 👤 **Portal Login Pasien** | [https://klinik-bunanur.infinityfreeapp.com/login_pasien](https://klinik-bunanur.infinityfreeapp.com/login_pasien) | Autentikasi akun pasien, reservasi antrean, & telekonsultasi |
| 🩺 **Portal Login Bidan (Admin)** | [https://klinik-bunanur.infinityfreeapp.com/login_bidan](https://klinik-bunanur.infinityfreeapp.com/login_bidan) | Pusat kendali medis, konfirmasi kunjungan, & moderasi ulasan |
| 💻 **Repository GitHub** | [https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git](https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git) | *Source code* resmi proyek CodeIgniter 4 |

- **Mata Kuliah:** Cyber Security / Keamanan Siber (Pengembangan & Pengamanan Aplikasi Web Terapan)
- **Kredensial Akun Pengujian:**
  - **Role Admin (Bidan):** Username `bidan_bunanur` | Password `[Silakan hubungi administrator / lihat lampiran laporan akademik]`
  - **Role User (Pasien):** Akun Pasien Terdaftar *(atau buat akun pasien baru secara instan melalui formulir registrasi)*

---

## 📖 Ringkasan Eksekutif & Arsitektur Sistem

**Klinik Bunanur** adalah aplikasi web layanan kesehatan ibu dan anak berbasis MVC (*Model-View-Controller*) yang dirancang khusus untuk memfasilitasi operasional klinik kebidanan modern. Sistem ini mencakup pendaftaran pasien secara digital, reservasi antrean layanan unggulan (*Baby Spa, Pijat Laktasi, Imunisasi Bayi, ANC Terpadu*), telekonsultasi medis interaktif dua arah, moderasi ulasan/testimoni pasien, dan rekam kunjungan digital.

Dibangun dengan prinsip *Zero Trust* dan *Defense-in-Depth*, sistem ini menerapkan kontrol keamanan siber komprehensif untuk memastikan kerahasiaan (*Confidentiality*), integritas (*Integrity*), dan ketersediaan (*Availability*) rekam medis serta privasi data pasien.

```
                    ┌───────────────────────────────────────────┐
                    │       Client Browser / Mobile App         │
                    └─────────────────────┬─────────────────────┘
                                          │ HTTPS (SSL/TLS)
                                          ▼
                    ┌───────────────────────────────────────────┐
                    │          SecurityHeadersFilter            │
                    │   (HSTS, CSP, X-Frame, X-Content, MIME)   │
                    └─────────────────────┬─────────────────────┘
                                          │
                                          ▼
                    ┌───────────────────────────────────────────┐
                    │               CSRF Filter                 │
                    │  (Token Validation & Strict Origin Match) │
                    └─────────────────────┬─────────────────────┘
                                          │
                        ┌─────────────────┴─────────────────┐
                        │                                   │
                        ▼                                   ▼
          ┌───────────────────────────┐       ┌───────────────────────────┐
          │      PasienAuthFilter     │       │      BidanAuthFilter      │
          │   (Dual-Layer Session)    │       │    (RBAC & Privilege)     │
          └─────────────┬─────────────┘       └─────────────┬─────────────┘
                        │                                   │
                        ▼                                   ▼
          ┌───────────────────────────┐       ┌───────────────────────────┐
          │     Patient Portal        │       │    Medical Center Admin   │
          │ (Reservasi, Chat, Profil) │       │ (Antrean, Rekam Medis)    │
          └─────────────┬─────────────┘       └─────────────┬─────────────┘
                        │                                   │
                        └─────────────────┬─────────────────┘
                                          │
                                          ▼
                    ┌───────────────────────────────────────────┐
                    │      BaseController / Heartbeat Sync      │
                    │     (Asia/Jakarta WIB & Last Seen)        │
                    └─────────────────────┬─────────────────────┘
                                          │
                        ┌─────────────────┴─────────────────┐
                        │                                   │
                        ▼                                   ▼
          ┌───────────────────────────┐       ┌───────────────────────────┐
          │  MySQL Database (InnoDB)  │       │  Fonnte WhatsApp Gateway  │
          │   (Prepared Statements)   │       │  (HTTPS REST API v2 POST) │
          └───────────────────────────┘       └───────────────────────────┘
```

---

## ✨ Fitur-Fitur Utama & Pembaruan Terkini

### 1. 🟢 Real-Time Presence & Heartbeat Synchronization
- **Indikator Kehadiran Pasien & Bidan:** Tampilan status aktif `• Online` (hijau bercahaya) dan `• Offline` (abu-abu) secara *real-time* pada sidebar dashboard pasien, kartu profil, serta direktori kontak konsultasi.
- **Sinkronisasi Zona Waktu Terpadu:** Konfigurasi PHP (`$appTimezone = 'Asia/Jakarta'`) dan sesi MySQL (`SET time_zone = '+07:00'`) berjalan presisi pada zona Waktu Indonesia Barat (WIB / UTC+7).
- **Background AJAX Heartbeat Engine:** Eksekusi pengiriman *heartbeat* otomatis di latar belakang setiap 30 detik untuk memperbarui timestamp `last_seen` dan `status = 'online'` tanpa me-refresh halaman.
- **Fail-Safe Timeout Threshold:** Pengguna yang tidak mengirimkan *heartbeat* dalam jangka waktu lebih dari 5 menit (300 detik) atau menutup peramban secara otomatis diklasifikasikan sebagai `offline`.

### 2. 📱 Mobile-First Responsive UI Optimization
- **Tipografi Adaptif (`clamp()`):** Skalabilitas ukuran judul (h1–h3), kartu statistik, dan paragraf menggunakan fungsi CSS dinamis (`clamp(...)`) sehingga nyaman dibaca di layar HP tanpa *font clipping*.
- **Desain Komponen Mobile (<= 768px dan <= 480px):**
  - Form input, tombol interaktif, dan modal popup disesuaikan dengan dimensi layar sentuh (*touch-friendly hit area*).
  - Kartu ringkasan (*cards*) dan tabel riwayat medis dilengkapi kemampuan *horizontal-scrollable* yang rapi tanpa menyebabkan kebocoran kontainer (`overflow-x: hidden`).
- **Drawer Navigation & Hamburger Menu:** Navigasi bilah samping (*sidebar*) yang dapat dibuka-tutup dengan animasi mulus pada perangkat ponsel pintar.
- **Aesthetic Soft Pink Glassmorphism 3D:** Sentuhan visual modern dengan transparansi kaca (*backdrop-filter: blur*), gradien lembut pastel pink/rose, dan efek kedalaman 3D yang ringan.

### 3. 🛡️ Keamanan Siber Berlapis (*Defense-in-Depth / OWASP ASVS*)
- **Cross-Site Request Forgery (CSRF) Protection:** Token CSRF acak kriptografis diinjeksikan pada seluruh formulir POST dan permintaan AJAX (`csrf_token()`, `csrf_hash()`) dengan *auto-refresh*.
- **Anti-Cross-Site Scripting (XSS):** Sanitasi seluruh variabel masukan dan penerapan fungsi *context-aware escaping* `esc()` pada layer presentasi (*View*).
- **Pencegahan SQL Injection (SQLi):** Larangan kueri SQL mentah; 100% manipulasi basis data dilakukan melalui *CodeIgniter 4 Query Builder* dan *Prepared Statements* dengan *parameter binding*.
- **Dual-Layer Session & Authentication Security:**
  - Sesi berbasis cookie dengan atribut ketat: `HttpOnly`, `SameSite=Lax`, dan `Secure = true` pada protokol HTTPS.
  - Regenerasi ID sesi secara berkala untuk mencegah serangan *Session Fixation*.
  - Enkripsi kata sandi menggunakan algoritma **Bcrypt** berbobot kerja tinggi (`cost => 12`).
- **Role-Based Access Control (RBAC):** Rute pasien dilindungi oleh `PasienAuthFilter` dan rute bidan/admin dilindungi oleh `BidanAuthFilter`. Rute registrasi publik bidan diblokir total (`403 Forbidden`) untuk mencegah *Privilege Escalation*.
- **WhatsApp OTP Gateway via Fonnte REST API:**
  - Pengiriman kode verifikasi OTP 6-digit rahasia secara *server-to-server* via cURL HTTPS POST ke `https://api.fonnte.com/send`.
  - Masa aktif OTP dibatasi 5 menit (300 detik) dengan pembatasan maksimal 5 kali percobaan salah (*anti brute-force*).
  - Mekanisme *cooldown* 60 detik sebelum pengguna diizinkan mengirim ulang OTP.
- **CyberShield CAPTCHA:** Sistem verifikasi perhitungan matematis dan teks dinamis pada halaman autentikasi untuk menangkal serangan bot otomatis (*credential stuffing*).
- **HTTP Security Headers Komprehensif:** Dilengkapi filter `SecurityHeadersFilter` yang menyuntikkan header standar industri:
  - `Content-Security-Policy (CSP)`
  - `Strict-Transport-Security: max-age=31536000; includeSubDomains; preload` (HSTS)
  - `X-Frame-Options: DENY` (Pencegahan Clickjacking)
  - `X-Content-Type-Options: nosniff` (Pencegahan MIME-Confusion Attack)
  - `Referrer-Policy: strict-origin-when-cross-origin`
  - `Permissions-Policy: camera=(), microphone=(), geolocation=()`

### 4. 🩺 Manajemen Layanan Medis, Telekonsultasi & Rekam Kunjungan
- **Katalog Layanan Unggulan:** Informasi detail dan estimasi durasi untuk Baby Spa, Pijat Laktasi, Imunisasi Bayi, dan Pemeriksaan Kehamilan (ANC).
- **Sistem Reservasi & Kuota Harian:** Pasien dapat memilih jadwal kunjungan dan bidan jaga, dengan pembatasan kapasitas harian otomatis untuk mencegah penumpukan antrean di klinik fisik.
- **Telekonsultasi Medis Dua Arah:** Modul perpesanan langsung antara pasien terdaftar dan bidan jaga untuk konsultasi keluhan awal ibu dan bayi.
- **Dashboard Analitik & Pelaporan:** Bidan dapat memantau grafik kunjungan bulanan, mengonfirmasi status kedatangan, serta memoderasi testimoni publik.

---

## 🛠️ Tech Stack & Spesifikasi Lingkungan

| Komponen | Teknologi yang Digunakan | Spesifikasi / Keterangan |
|---|---|---|
| **Bahasa Pemrograman** | PHP | Versi 8.2+ (Ekstensi `intl`, `mbstring`, `curl`, `mysqli`, `openssl` aktif) |
| **Kerangka Kerja Web** | CodeIgniter 4 | Versi 4.7.3 (Arsitektur MVC) |
| **Sistem Basis Data** | MySQL / MariaDB | Engine InnoDB, Default Charset `utf8mb4_unicode_ci` |
| **Frontend Framework** | HTML5, CSS3, JavaScript | Bootstrap 5.3, Custom 3D Glassmorphism, Boxicons, Chart.js |
| **Komunikasi Eksternal** | Fonnte WhatsApp API | HTTPS cURL Server-to-Server Gateway |
| **Web Server & Hosting** | Apache HTTP Server | Mod-Rewrite `.htaccess` aktif, InfinityFree Linux (SSL/TLS Let's Encrypt) |

---

## 🚀 Panduan Instalasi Lokal (Development / XAMPP)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi pada komputer lokal menggunakan XAMPP:

### 1. Prasyarat Sistem
- **XAMPP** dengan PHP 8.2 ke atas dan MySQL/MariaDB aktif.
- **Composer** (v2.x) terpasang secara global di sistem operasi.
- **Git** CLI terinstal.

### 2. Kloning Repositori & Instalasi Dependensi
```bash
# 1. Masuk ke direktori web root XAMPP
cd C:\xampp\htdocs

# 2. Clone repositori resmi dari GitHub
git clone https://github.com/kaniasalsa23-beep/klinik-bunanur-ci4.git klinik-ci4
cd klinik-ci4

# 3. Unduh seluruh dependensi vendor via Composer
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin berkas percontohan konfigurasi lingkungan:
```bash
copy env .env
```
Buka file `.env` dan atur parameter berikut untuk pengujian lokal:
```ini
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false
app.appTimezone = 'Asia/Jakarta'

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = klinik_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port     = 3306

#--------------------------------------------------------------------
# WHATSAPP OTP GATEWAY (FONNTE API)
#--------------------------------------------------------------------
FONNTE_TOKEN = "your_fonnte_token_here"
WHATSAPP_GATEWAY_URL = "https://api.fonnte.com/send"
WHATSAPP_GATEWAY_TOKEN = "your_fonnte_token_here"
BIDAN_OFFICIAL_WHATSAPP = "6281224841377"

#--------------------------------------------------------------------
# SECURITY & JWT SECRET
#--------------------------------------------------------------------
security.csrfProtection = 'cookie'
security.tokenRandomize = true
JWT_SECRET = "your_strong_random_secret_key_minimum_32_characters"
```

### 4. Setup Basis Data & Seeder
Buat basis data kosong bernama `klinik_db` melalui phpMyAdmin (`http://localhost/phpmyadmin`), kemudian jalankan:
```bash
# Eksekusi skema migrasi tabel
php spark migrate

# Masukkan data awal akun resmi Bidan Jaga
php spark db:seed BidanWhatsAppSeeder
```

### 5. Jalankan Server Pengembangan
```bash
php spark serve
```
Buka peramban dan akses: **`http://localhost:8080/`**

---

## 🌐 Panduan Konfigurasi Server Produksi (Hosting / cPanel / InfinityFree)

Saat memublikasikan aplikasi ke server produksi berbasis HTTPS (seperti InfinityFree atau cPanel):

1. **Struktur Folder Web Server:**
   - Unggah seluruh direktori proyek ke folder root web server (pada InfinityFree: `htdocs/`, atau pada cPanel: `public_html/`).
   - Pastikan berkas `.htaccess` di root dan di dalam folder `public/` terunggah dengan sempurna untuk menangani rute rewrite Apache.
2. **Konfigurasi Environment Produksi (`.env`):**
   Pastikan parameter keamanan berikut diaktifkan:
   ```ini
   CI_ENVIRONMENT = production

   app.baseURL = 'https://klinik-bunanur.infinityfreeapp.com/'
   app.forceGlobalSecureRequests = true
   app.appTimezone = 'Asia/Jakarta'

   database.default.hostname = sqlxxx.infinityfree.com
   database.default.database = if0_xxxxxxxx_klinik_db
   database.default.username = if0_xxxxxxxx
   database.default.password = your_hosting_db_password
   database.default.DBDriver = MySQLi

   # Token Fonnte WhatsApp API
   FONNTE_TOKEN = "your_production_fonnte_token"
   WHATSAPP_GATEWAY_URL = "https://api.fonnte.com/send"
   WHATSAPP_GATEWAY_TOKEN = "your_production_fonnte_token"
   BIDAN_OFFICIAL_WHATSAPP = "6281224841377"
   ```
3. **Izin Hak Akses Direktori (*Directory Permissions*):**
   Pastikan direktori `/writable` dan seluruh subdirektorinya (`/writable/cache`, `/writable/session`, `/writable/logs`, `/writable/uploads`) memiliki izin tulis (**chmod 755** atau **chmod 777** sesuai regulasi server).

---

## 🧪 Matriks Pengujian Keamanan & Penetrasi (*OWASP ASVS*)

| No | Kategori Kerentanan | Skenario Uji Penetrasi | Hasil Evaluasi | Mekanisme Pertahanan (*Countermeasure*) |
|:--:|---|---|:---:|---|
| **1** | **SQL Injection (SQLi)** | Injeksi payload tautologi `' OR '1'='1` dan *sleep payload* pada form login dan filter pencarian. | **Lolos (Aman)** | *Parameter Binding* & *Query Builder* bawaan CI4 tanpa konkatenasi string SQL mentah. |
| **2** | **Cross-Site Scripting (XSS)** | Penyuntikan payload `<script>alert(document.cookie)</script>` pada form chat medis & ulasan. | **Lolos (Aman)** | Sanitasi input dan penggunaan fungsi *contextual HTML escaping* `esc()` pada seluruh view. |
| **3** | **Broken Access Control & IDOR** | Pasien memodifikasi ID pada URL untuk mengakses data kunjungan pasien lain atau modul `/bidan/*`. | **Lolos (Aman)** | Filter `PasienAuthFilter` & `BidanAuthFilter`, pencocokan ID kepemilikan data dengan sesi aktif. |
| **4** | **Brute-Force & OTP Guessing** | Pengiriman percobaan tebakan 6-digit OTP secara masif menggunakan skrip otomatisasi. | **Lolos (Aman)** | Penguncian otomatis setelah 5 kali gagal, masa berlaku OTP 300 detik, dan *rate limiting*. |
| **5** | **Cross-Site Request Forgery** | Pengiriman form POST dari domain pihak ketiga tanpa membawa token keamanan. | **Lolos (Aman)** | Verifikasi *hash* token CSRF aktif secara global pada seluruh *endpoint* POST. |
| **6** | **Session Hijacking & Fixation** | Pemeriksaan nilai cookie sesi saat login, logout, dan perpindahan peran pengguna. | **Lolos (Aman)** | Regenerasi ID sesi otomatis (`session()->regenerate()`), flag `HttpOnly`, `SameSite=Lax`, dan `Secure`. |
| **7** | **MIME-Sniffing & Clickjacking** | Pengujian penyematan aplikasi ke dalam tag `<iframe>` dan manipulasi tipe berkas unggahan. | **Lolos (Aman)** | Header `X-Frame-Options: DENY` dan `X-Content-Type-Options: nosniff` via `SecurityHeadersFilter`. |

---

## 🤖 Transparansi Penggunaan AI Agent

Sesuai dengan ketentuan integritas akademik mata kuliah Cyber Security:
- **Alat Bantu AI yang Digunakan:** Gemini (Google DeepMind)
- **Ruang Lingkup Kolaborasi AI:**
  1. Perancangan skema keamanan kriptografi OTP WhatsApp pada tabel `password_resets`.
  2. Implementasi sinkronisasi presensi waktu nyata (*Real-Time Heartbeat Engine*) dengan zona waktu `Asia/Jakarta`.
  3. Optimasi desain antarmuka responsif ramah seluler (*Mobile-First Responsive Design*) pada resolusi `<= 768px` dan `<= 480px`.
  4. Penyusunan filter keamanan HTTP Security Headers dan konfigurasi `.htaccess` kompatibel hosting.
  5. Penyusunan skenario uji penetrasi mandiri (*self-testing*) berbasis standar OWASP ASVS.
- **Verifikasi Mandiri oleh Mahasiswa:** Seluruh kode yang dihasilkan asisten AI telah ditinjau baris demi baris, diuji sintaksnya (`php -l`), divalidasi aliran datanya melalui pengujian rute fungsional, dan diverifikasi secara langsung pada lingkungan lokal maupun server produksi.

---

## 📄 Lisensi & Hak Cipta

Project ini dikembangkan sebagai karya akademik pemenuhan tugas proyek mata kuliah **Cyber Security**. Seluruh kode sumber, aset desain grafis, dan dokumentasi dilindungi dan diperuntukkan bagi tujuan edukasi serta pengembangan teknologi pelayanan kesehatan masyarakat.
