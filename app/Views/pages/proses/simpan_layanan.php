<?php
include '../config/koneksi.php';


/** @var mysqli $conn */

$nama=$_POST['nama_layanan'];
$kategori=$_POST['kategori'];
$harga=$_POST['harga'];
$durasi=$_POST['durasi'];
$deskripsi=$_POST['deskripsi'];

$namaFoto=
time().'_'.$_FILES['gambar']['name'];

$tmp=
$_FILES['gambar']['tmp_name'];

move_uploaded_file(
$tmp,
"../assets/layanan/".$namaFoto
);

mysqli_query($conn,"
INSERT INTO layanan
(
nama_layanan,
kategori,
harga,
durasi,
deskripsi,
gambar,
status,
created_at
)
VALUES
(
'$nama',
'$kategori',
'$harga',
'$durasi',
'$deskripsi',
'$namaFoto',
'aktif',
NOW()
)
");

header(
"location:../pages/kelola_layanan.php"
);