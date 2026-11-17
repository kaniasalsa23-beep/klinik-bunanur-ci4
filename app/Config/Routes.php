<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// PUBLIC ROUTES (Beranda & Guest)
// ==========================================
$routes->get('/', 'Home::index');
$routes->get('logout', 'Home::logout');
$routes->get('daftar-layanan', 'Home::daftarLayanan');
$routes->get('daftar_layanan', 'Home::daftarLayanan');

// Autentikasi Pasien (Publik / Guest)
$routes->get('register', 'Home::register');
$routes->get('register_pasien', 'Home::register');
$routes->post('register_proses', 'Home::registerProses');
$routes->get('login_pasien', 'Home::loginForm');
$routes->post('login_pasien', 'Home::login');

// Autentikasi Bidan (Publik / Guest — HANYA LOGIN)
// BIDAN REGISTRATION LOCKDOWN: Semua upaya pendaftaran Bidan publik ditolak (403 Forbidden)
$routes->get('register_bidan', 'Home::registerBidanBlocked');
$routes->post('register_bidan', 'Home::registerBidanBlocked');
$routes->get('register_bidan/(:any)', 'Home::registerBidanBlocked');
$routes->post('register_bidan/(:any)', 'Home::registerBidanBlocked');
$routes->get('login_bidan', 'Home::loginBidanForm');
$routes->post('login_bidan', 'Home::prosesLoginBidan');

// ==========================================
// LUPA KATA SANDI VIA WHATSAPP OTP (Bidan & Pasien)
// ==========================================
// Alur Lupa Sandi Bidan Nurhayati
$routes->get('bidan/lupa-sandi', 'Home::lupaSandiBidan');
$routes->post('bidan/lupa-sandi', 'Home::prosesLupaSandiBidan');
$routes->post('bidan/lupa-sandi/proses', 'Home::prosesLupaSandiBidan');
$routes->get('bidan/otp-verifikasi', 'Home::otpVerifikasiBidan');
$routes->post('bidan/otp-verifikasi', 'Home::prosesOtpVerifikasiBidan');
$routes->post('bidan/otp-verifikasi/proses', 'Home::prosesOtpVerifikasiBidan');
$routes->match(['get', 'post'], 'bidan/kirim-ulang-otp', 'Home::kirimUlangOtpBidan');
$routes->get('bidan/reset-sandi', 'Home::resetSandiBidan');
$routes->post('bidan/reset-sandi', 'Home::prosesResetSandiBidan');
$routes->post('bidan/reset-sandi/proses', 'Home::prosesResetSandiBidan');

// Alur Lupa Sandi Pasien
$routes->get('lupa-sandi', 'Home::lupaSandiPasien');
$routes->get('pasien/lupa-sandi', 'Home::lupaSandiPasien');
$routes->post('lupa-sandi', 'Home::prosesLupaSandiPasien');
$routes->post('lupa-sandi/proses', 'Home::prosesLupaSandiPasien');
$routes->post('pasien/lupa-sandi', 'Home::prosesLupaSandiPasien');
$routes->get('pasien/otp-verifikasi', 'Home::otpVerifikasiPasien');
$routes->get('otp-verifikasi', 'Home::otpVerifikasiPasien');
$routes->post('pasien/otp-verifikasi', 'Home::prosesOtpVerifikasiPasien');
$routes->post('pasien/otp-verifikasi/proses', 'Home::prosesOtpVerifikasiPasien');
$routes->post('otp-verifikasi', 'Home::prosesOtpVerifikasiPasien');
$routes->match(['get', 'post'], 'pasien/kirim-ulang-otp', 'Home::kirimUlangOtpPasien');
$routes->match(['get', 'post'], 'kirim-ulang-otp', 'Home::kirimUlangOtpPasien');
$routes->get('pasien/reset-sandi', 'Home::resetSandiPasien');
$routes->get('reset-sandi', 'Home::resetSandiPasien');
$routes->post('pasien/reset-sandi', 'Home::prosesResetSandiPasien');
$routes->post('pasien/reset-sandi/proses', 'Home::prosesResetSandiPasien');
$routes->post('reset-sandi', 'Home::prosesResetSandiPasien');



// ==========================================
// PASIEN PROTECTED ROUTES (RBAC: pasienAuth)
// ==========================================
$routes->group('', ['filter' => 'pasienAuth'], static function ($routes) {
    $routes->get('dashboard_pasien', 'Home::dashboardPasien');
    $routes->get('pasien/dashboard', 'Home::dashboardPasien');

    // Konsultasi Pasien
    $routes->get('konsultasi', 'Home::konsultasi');
    $routes->get('pasien/konsultasi', 'Home::konsultasi');
    $routes->post('kirim_chat', 'Home::kirimChat');

    // Layanan & Booking Pasien
    $routes->get('layanan', 'Home::layanan');
    $routes->get('pasien/layanan', 'Home::layanan');
    $routes->get('ajukan_kunjungan/(:num)', 'Home::ajukanKunjungan/$1');
    $routes->post('ajukan_kunjungan/proses', 'Home::prosesAjukanKunjungan');

    // Profil Pasien
    $routes->get('profil', 'Home::profil');
    $routes->get('/profil', 'Home::profil');
    $routes->get('pasien/profil', 'Home::profil');
    $routes->post('profil/update', 'Home::updateProfil');
    $routes->post('/profil/update', 'Home::updateProfil');
    $routes->post('hapus_akun', 'Home::hapusAkun');
    $routes->post('/hapus_akun', 'Home::hapusAkun');

    // Riwayat & Ulasan Pasien
    $routes->get('riwayat', 'Home::riwayat');
    $routes->get('riwayat_kunjungan', 'Home::riwayat');
    $routes->get('pasien/kunjungan', 'Home::riwayat');
    $routes->get('rating', 'Home::rating');
    $routes->get('pasien/testimoni', 'Home::rating');
    $routes->post('simpan-rating', 'Home::simpanRating');

    // Logout Pasien
    $routes->get('logout', 'Home::logout');
});

// ==========================================
// BIDAN PROTECTED ROUTES (RBAC: bidanAuth)
// ==========================================
$routes->group('', ['filter' => 'bidanAuth'], static function ($routes) {
    $routes->get('dashboard_bidan', 'Home::dashboardBidan');
    $routes->get('bidan/dashboard', 'Home::dashboardBidan');
    $routes->get('bidan/updateLastSeen', 'Home::updateLastSeen');

    // Kelola Layanan Medis
    $routes->get('kelola_layanan', 'Home::kelolaLayanan');
    $routes->get('bidan/layanan', 'Home::kelolaLayanan');
    $routes->match(['GET', 'POST'], 'tambah_layanan', 'Home::tambahLayanan');
    $routes->get('hapus_layanan/(:num)', 'Home::hapusLayanan/$1');
    $routes->match(['GET', 'POST'], 'edit_layanan/(:num)', 'Home::editLayanan/$1');
    $routes->post('update_layanan/(:num)', 'Home::updateLayanan/$1');

    // Pasien Aktif
    $routes->get('pasien_aktif', 'Home::pasienAktif');
    $routes->get('hapus_pasien/(:num)', 'Home::hapusPasien/$1');

    // Konsultasi Online Bidan
    $routes->get('konsultasi_bidan', 'Home::konsultasiBidan');
    $routes->get('bidan/konsultasi', 'Home::konsultasiBidan');
    $routes->get('konsultasi_bidan/(:num)', 'Home::konsultasiBidan/$1');
    $routes->get('bidan/konsultasi/(:num)', 'Home::konsultasiBidan/$1');
    $routes->post('kirim_balasan', 'Home::kirimBalasan');
    $routes->get('hapus_chat/(:num)', 'Home::hapusChat/$1');

    // Kunjungan & Janji Temu Medis
    $routes->get('kunjungan_bidan', 'Home::kunjunganBidan');
    $routes->get('bidan/kunjungan', 'Home::kunjunganBidan');
    $routes->get('kunjungan_bidan/aksi/(:segment)/(:num)', 'Home::aksiKunjungan/$1/$2');
    $routes->get('kunjungan_bidan/pdf', 'Home::pdfKunjungan');
    $routes->get('bidan/laporan', 'Home::pdfKunjungan');

    // Testimoni Pasien
    $routes->get('testimoni_bidan', 'Home::testimoniBidan');
    $routes->get('bidan/testimoni', 'Home::testimoniBidan');
    $routes->get('testimoni/publish/(:num)', 'Home::publishTestimoni/$1');
    $routes->get('testimoni/unpublish/(:num)', 'Home::unpublishTestimoni/$1');
    $routes->get('testimoni/hapus/(:num)', 'Home::hapusTestimoni/$1');

    // Profil Bidan & Galeri Klinik
    $routes->match(['GET', 'POST'], 'edit_profil_bidan', 'Home::editProfilBidan');
    $routes->get('bidan/profil', 'Home::editProfilBidan');
    $routes->get('bidan/galeri', 'Home::editProfilBidan');
    $routes->post('update_profil_bidan', 'Home::updateProfilBidan');
    $routes->post('tambah_galeri', 'Home::tambahGaleri');
    $routes->get('hapus_galeri/(:num)', 'Home::hapusGaleri/$1');

    // Logout Bidan
    $routes->get('logout_bidan', 'Home::logoutBidan');
    $routes->get('logout', 'Home::logout');
});
