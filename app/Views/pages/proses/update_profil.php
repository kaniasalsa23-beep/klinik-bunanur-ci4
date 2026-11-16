<?php
session_start();
include '../config/koneksi.php';


/** @var mysqli $conn */

$id = $_SESSION['pasien']['id'];

if (isset($_POST['update'])) {

    $nama = $_POST['nama'];

    // ambil data lama
    $q = mysqli_query($conn, "SELECT foto FROM pasien WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    $foto_lama = $d['foto'];

    // cek upload
    if ($_FILES['foto']['name'] != "") {

        $nama_file = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];

        // rename biar unik
        $foto_baru = time() . '_' . $nama_file;

        move_uploaded_file($tmp, "../assets/img/" . $foto_baru);

        // hapus foto lama (kecuali default)
        if ($foto_lama != "default.png") {
            unlink("../assets/img/" . $foto_lama);
        }

    } else {
        $foto_baru = $foto_lama;
    }

    // update DB
    mysqli_query($conn, "UPDATE pasien SET 
        nama='$nama',
        foto='$foto_baru'
        WHERE id='$id'
    ");

    // update session biar langsung ke-refresh
    $_SESSION['pasien']['nama'] = $nama;
    $_SESSION['pasien']['foto'] = $foto_baru;

    header("Location: ../pages/dashboard_pasien.php");
}