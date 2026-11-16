<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

// =========================
// LOGOUT BIDAN
// =========================
if (isset($_SESSION['bidan'])) {

    // ambil id bidan
    $id_bidan = $_SESSION['bidan']['id'];

    // langsung jadikan offline
    mysqli_query($conn, "
    UPDATE bidan
    SET last_seen = DATE_SUB(NOW(), INTERVAL 10 MINUTE)
    WHERE id='$id_bidan'
    ");

    // hapus session bidan
    unset($_SESSION['bidan']);

    // hancurkan session
    session_destroy();

    // kembali ke login bidan
    header("Location: login_bidan.php");
    exit;
}

// =========================
// LOGOUT PASIEN
// =========================
if (isset($_SESSION['pasien'])) {

    // hapus session pasien
    unset($_SESSION['pasien']);

    // hancurkan session
    session_destroy();

    // kembali ke beranda
    header("Location: ../index.php");
    exit;
}

// =========================
// JIKA TIDAK ADA SESSION
// =========================
header("Location: ../index.php");
exit;
?>