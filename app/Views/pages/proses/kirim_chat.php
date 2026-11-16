<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

// 1. CEK LOGIN
if(!isset($_SESSION['pasien'])){
    header("Location: ../pages/login_pasien.php");
    exit;
}

$id_pasien = $_SESSION['pasien']['id'];

/* =====================
   CEK LIMIT DARI DATABASE
   (Bukan dari Session agar lebih akurat)
===================== */
// Menghitung hanya pesan yang dikirim oleh pasien (user)
$q_limit = mysqli_query($conn, "SELECT COUNT(*) total FROM chat WHERE id_pasien='$id_pasien' AND (pengirim = 'user' OR pengirim IS NULL)");
$d_limit = mysqli_fetch_assoc($q_limit);
$total_pesan_pasien = $d_limit['total'];

$limit_maksimal = 10; // Sesuaikan dengan tampilan (10 pesan)

if($total_pesan_pasien >= $limit_maksimal){
    die("Limit konsultasi habis, silakan lanjut via WhatsApp.");
}

/* =====================
   PROSES KIRIM CHAT
===================== */
if(isset($_POST['kirim'])){

    $pesan = isset($_POST['pesan']) 
        ? mysqli_real_escape_string($conn, $_POST['pesan']) 
        : '';

    if(!empty($pesan)){
        $pengirim = 'user';
        $status_baca = 'terkirim';

        $query = mysqli_query($conn,"
            INSERT INTO chat(
                id_pasien,
                pesan,
                pengirim,
                status,
                status_baca,
                created_at
            )
            VALUES(
                '$id_pasien',
                '$pesan',
                '$pengirim',
                'baru',
                '$status_baca',
                NOW()
            )
        ");

        if(!$query){
            die("Gagal kirim pesan: " . mysqli_error($conn));
        }

        // HAPUS baris $_SESSION['chat_limit']-- agar tidak bentrok
    }

    header("Location: ../pages/konsultasi.php");
    exit;
}
?>