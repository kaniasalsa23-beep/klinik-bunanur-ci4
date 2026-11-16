<?php

session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

// ======================
// CEK LOGIN
// ======================
if (!isset($_SESSION['pasien'])) {
    header("Location: ../login_pasien.php");
    exit;
}

$id_pasien = (int) $_SESSION['pasien']['id'];

// ======================
// AMBIL DATA FORM
// ======================
$kunjungan_id = isset($_POST['id_kunjungan'])
    ? (int) $_POST['id_kunjungan']
    : 0;

$rating = isset($_POST['rating'])
    ? (int) $_POST['rating']
    : 0;

$ulasan = isset($_POST['ulasan'])
    ? mysqli_real_escape_string($conn, trim($_POST['ulasan']))
    : '';

$foto_final = '';

// ======================
// VALIDASI
// ======================
if ($kunjungan_id <= 0) {
    echo "<script>
        alert('ID kunjungan tidak valid');
        window.history.back();
    </script>";
    exit;
}

if ($rating < 1 || $rating > 5) {
    echo "<script>
        alert('Rating harus 1 sampai 5');
        window.history.back();
    </script>";
    exit;
}

if (empty($ulasan)) {
    echo "<script>
        alert('Ulasan wajib diisi');
        window.history.back();
    </script>";
    exit;
}

// ======================
// CEK KUNJUNGAN MILIK PASIEN
// ======================
$cekKunjungan = mysqli_query(
    $conn,
    "SELECT id 
     FROM kunjungan
     WHERE id = '$kunjungan_id'
     AND pasien_id = '$id_pasien'"
);

if (mysqli_num_rows($cekKunjungan) == 0) {
    echo "<script>
        alert('Data kunjungan tidak ditemukan');
        window.history.back();
    </script>";
    exit;
}

// ======================
// UPLOAD FOTO
// ======================
if (
    isset($_FILES['foto']) &&
    $_FILES['foto']['error'] == 0
) {

    $target_dir = "../assets/testimoni/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_ext = strtolower(
        pathinfo(
            $_FILES['foto']['name'],
            PATHINFO_EXTENSION
        )
    );

    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($file_ext, $allowed_types)) {

        $nama_file_baru =
            "TESTI_" .
            time() .
            "_" .
            $id_pasien .
            "." .
            $file_ext;

        $target_file =
            $target_dir .
            $nama_file_baru;

        if (
            move_uploaded_file(
                $_FILES['foto']['tmp_name'],
                $target_file
            )
        ) {
            $foto_final = $nama_file_baru;
        }
    }
}

// ======================
// CEK DUPLIKASI TESTIMONI
// ======================
$cek = mysqli_query(
    $conn,
    "SELECT id
     FROM testimoni
     WHERE kunjungan_id = '$kunjungan_id'"
);

if (mysqli_num_rows($cek) > 0) {

    echo "<script>
        alert('Anda sudah memberikan testimoni untuk kunjungan ini');
        window.location='../riwayat.php';
    </script>";

    exit;
}

// ======================
// SIMPAN TESTIMONI
// ======================
$query = "
INSERT INTO testimoni
(
    pasien_id,
    kunjungan_id,
    rating,
    ulasan,
    foto,
    approve
)
VALUES
(
    '$id_pasien',
    '$kunjungan_id',
    '$rating',
    '$ulasan',
    '$foto_final',
    'SELESAI'
)
";

$result = mysqli_query($conn, $query);

if (!$result) {

    die(
        "MYSQL ERROR : " .
        mysqli_error($conn)
    );
}

// ======================
// REDIRECT BERHASIL
// ======================
echo "<script>
    alert('Terima kasih! Testimoni berhasil dikirim.');
    window.location='../riwayat.php';
</script>";

exit;
?>
