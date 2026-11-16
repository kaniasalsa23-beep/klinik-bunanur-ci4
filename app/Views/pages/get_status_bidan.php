<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

$online = false;

// cek apakah ada session bidan aktif
if(isset($_SESSION['bidan'])){

    $id_bidan = $_SESSION['bidan']['id'];

    $query = mysqli_query($conn,"
    SELECT last_seen
    FROM bidan
    WHERE id='$id_bidan'
    LIMIT 1
    ");

    $bidan = mysqli_fetch_assoc($query);

    if($bidan && !empty($bidan['last_seen'])){

        $last = strtotime($bidan['last_seen']);

        // online jika aktif < 10 detik
        if(time() - $last <= 10){
            $online = true;
        }
    }
}

echo json_encode([
    'status' => $online ? 'online' : 'offline'
]);
?>