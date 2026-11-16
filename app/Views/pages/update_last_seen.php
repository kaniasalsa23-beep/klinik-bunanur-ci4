<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

if(isset($_SESSION['bidan'])){
    $id = $_SESSION['bidan']['id'];

    mysqli_query($conn,"
    UPDATE bidan SET last_seen = NOW()
    WHERE id='$id'
    ");
}