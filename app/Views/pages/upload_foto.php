<?php
session_start();
include '../config/koneksi.php';


/** @var mysqli $conn */

$id = $_SESSION['pasien']['id'];

$namaFile = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];

move_uploaded_file($tmp, "../assets/profile/" . $namaFile);

mysqli_query($conn, "UPDATE pasien SET foto='$namaFile' WHERE id='$id'");

$_SESSION['pasien']['foto'] = $namaFile;

header("Location: ../index.php");

