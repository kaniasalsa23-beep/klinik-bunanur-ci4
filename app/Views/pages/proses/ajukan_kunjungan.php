<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

// 1. CEK LOGIN
if(!isset($_SESSION['pasien'])){
    header("Location: ../pages/login_pasien.php");
    exit;
}

// 2. CEK METHOD
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../pages/layanan.php");
    exit;
}

// 3. TANGKAP DATA
$pasien_id   = $_SESSION['pasien']['id'];
$nama_pasien = $_POST['nama'] ?? '';
$usia        = $_POST['usia'] ?? 0;
$nama_ortu   = $_POST['ortu'] ?? '';
$kategori    = $_POST['kategori_pendamping'] ?? ''; // Menangkap "Suami" atau "Orang Tua"
$alamat      = $_POST['alamat'] ?? '';
$layanan     = $_POST['layanan'] ?? '';
$tanggal     = $_POST['tanggal'] ?? '';
$jam         = $_POST['jam'] ?? '';

// Validasi dasar
if(empty($layanan) || empty($tanggal) || empty($nama_pasien) || empty($jam) || empty($kategori)){
    echo "<script>alert('Data tidak lengkap!'); window.history.back();</script>";
    exit;
}

// 4. VALIDASI TANGGAL (TIDAK BOLEH LEWAT)
if(strtotime($tanggal) < strtotime(date('Y-m-d'))){
    echo "<script>alert('Ups! Tidak bisa memilih tanggal yang sudah lewat.'); window.history.back();</script>";
    exit;
}

// 5. CEK DOUBLE INPUT (1 PASIEN 1 JADWAL PER HARI)
$cek_user = $conn->prepare("SELECT id FROM kunjungan WHERE pasien_id = ? AND tanggal = ? AND status != 'Gagal'");
$cek_user->bind_param("is", $pasien_id, $tanggal);
$cek_user->execute();
if($cek_user->get_result()->num_rows > 0){
    echo "<script>alert('Anda sudah memiliki jadwal aktif di tanggal ini!'); window.history.back();</script>";
    exit;
}

// 6. CEK KUOTA HARIAN (MAKS 5)
$stmt_kuota = $conn->prepare("SELECT COUNT(*) as total FROM kunjungan WHERE tanggal = ? AND status != 'Gagal'");
$stmt_kuota->bind_param("s", $tanggal);
$stmt_kuota->execute();
$data_kuota = $stmt_kuota->get_result()->fetch_assoc();

if($data_kuota['total'] >= 5){
    echo "<script>alert('Maaf, kuota untuk tanggal tersebut sudah penuh.'); window.history.back();</script>";
    exit;
}

// 7. EKSEKUSI INSERT DATA (DENGAN KOLOM BARU)
$stmt = $conn->prepare("
    INSERT INTO kunjungan (pasien_id, nama_pasien, usia, nama_ortu, kategori_pendamping, alamat, layanan, tanggal, jam, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu')
");

// i = integer, s = string. Total 9 parameter (isissssss)
// Penjelasan urutan:
// 1. pasien_id (i)
// 2. nama_pasien (s)
// 3. usia (i)
// 4. nama_ortu (s)
// 5. kategori (s) -> Di DB adalah ENUM, di PHP kirim String
// 6. alamat (s)
// 7. layanan (i) -> DI DB ADALAH INT
// 8. tanggal (s)
// 9. jam (s)

$stmt->bind_param("isisissss", // Jika layanan adalah ID (Integer), gunakan 'i' di urutan ke-7
    $pasien_id, 
    $nama_pasien, 
    $usia, 
    $nama_ortu, 
    $kategori, 
    $alamat, 
    $layanan, 
    $tanggal, 
    $jam
);

if($stmt->execute()){
    echo "<script>
            alert('Kunjungan untuk " . addslashes($nama_pasien) . " berhasil diajukan!'); 
            window.location.href='../pages/riwayat.php?status=sukses';
          </script>";
    exit;
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
}
?>