<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

if(!isset($_SESSION['bidan'])){
    header("Location: ../pages/login_bidan.php");
    exit;
}

$id_pasien = $_POST['id_pasien'];
$pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

/* =========================
   SIMPAN BALASAN BIDAN
========================= */
mysqli_query($conn,"
INSERT INTO chat (
    id_pasien,
    pesan,
    pengirim,
    status,
    status_baca
)
VALUES (
    '$id_pasien',
    '$pesan',
    'bidan',
    'dibalas',
    'dibaca'
)
");

/* =========================
   UBAH SEMUA PESAN USER JADI DIBACA
========================= */
mysqli_query($conn,"
UPDATE chat
SET status_baca='dibaca'
WHERE id_pasien='$id_pasien'
AND pengirim='user'
");

/* =========================
   KEMBALI KE DETAIL CHAT
========================= */
header("Location: ../pages/detail_chat.php?id_pasien=".$id_pasien);
exit;