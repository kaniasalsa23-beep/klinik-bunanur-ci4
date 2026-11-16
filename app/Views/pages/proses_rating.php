<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

// 1. Validasi Sesi Login
if(!isset($_SESSION['pasien'])){
    header("Location: ../pages/login_pasien.php");
    exit;
}

$pasien_id = $_SESSION['pasien']['id'];

/* 2. VALIDASI INPUT */
$kunjungan_id = isset($_POST['id_kunjungan']) ? (int)$_POST['id_kunjungan'] : 0;
$rating       = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
$ulasan       = isset($_POST['ulasan']) ? mysqli_real_escape_string($conn, trim($_POST['ulasan'])) : '';

if($kunjungan_id <= 0){
    die("Error: ID Kunjungan tidak terbaca. Periksa atribut 'name' pada form Anda.");
}

if($rating <= 0 || empty($ulasan)){
    die("Error: Rating dan ulasan wajib diisi.");
}

/* 3. VERIFIKASI DATA DI DATABASE */
$cek_kunjungan = mysqli_query($conn, "SELECT id FROM kunjungan WHERE id='$kunjungan_id' AND pasien_id='$pasien_id'");
if(mysqli_num_rows($cek_kunjungan) == 0){
    die("Error: Data kunjungan tidak valid atau bukan milik Anda.");
}

$cek_testimoni = mysqli_query($conn, "SELECT id FROM testimoni WHERE kunjungan_id='$kunjungan_id'");
if(mysqli_num_rows($cek_testimoni) > 0){
    die("Error: Anda sudah memberikan testimoni untuk layanan ini.");
}

/* 4. PROSES UPLOAD FOTO (OPSIONAL) */
$foto = '';
if(!empty($_FILES['foto']['name'])){
    $nama_file = $_FILES['foto']['name'];
    $tmp       = $_FILES['foto']['tmp_name'];
    $size      = $_FILES['foto']['size'];

    $ext     = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if($size > 2 * 1024 * 1024) {
        die("Error: Ukuran foto maksimal 2MB.");
    }

    if(!in_array($ext, $allowed)){
        die("Error: Format foto harus JPG, PNG, atau WebP.");
    }

    $folder = '../assets/testimoni/';
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $foto = time().'_'.uniqid().'.'.$ext;
    move_uploaded_file($tmp, $folder . $foto);
}

/* 5. EKSEKUSI PENYIMPANAN */
// Status 'approve' diset ke 'SELESAI' (Kapital) agar cocok dengan dashboard dan index
$query = "INSERT INTO testimoni (
    pasien_id,
    kunjungan_id,
    rating,
    ulasan,
    foto,
    approve
) VALUES (
    '$pasien_id',
    '$kunjungan_id',
    '$rating',
    '$ulasan',
    '$foto',
    'SELESAI' 
)";

if(mysqli_query($conn, $query)){
    header("Location: ../pages/riwayat.php?status=berhasil");
    exit;
} else {
    die("Error Database: " . mysqli_error($conn));
}
?>