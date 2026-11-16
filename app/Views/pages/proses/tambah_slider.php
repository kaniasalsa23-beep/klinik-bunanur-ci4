<?php
include '../config/koneksi.php'; // Pastikan path koneksi benar


/** @var mysqli $conn */

if (isset($_POST['simpan_slider'])) {
    $nama_file = $_FILES['foto']['name'];
    $tmp_file = $_FILES['foto']['tmp_name'];
    
    // 1. Ambil input judul/deskripsi dari form. 
    // Ini nanti yang akan muncul di bawah tulisan "Layanan Kami".
    $judul = mysqli_real_escape_string($conn, $_POST['judul_slider']);

    // 2. Memberi nama unik agar file tidak tumpuk
    $nama_baru = time() . "_" . str_replace(' ', '_', $nama_file);
    $path = "../assets/slider/" . $nama_baru;

    // 3. Validasi & Proses Upload
    $tipe_file = pathinfo($path, PATHINFO_EXTENSION);
    if(in_array($tipe_file, ['jpg','jpeg','png'])){
        if (move_uploaded_file($tmp_file, $path)) {
            // Simpan ke tabel 'tentang_slider'
            // Gunakan status 'aktif' agar langsung muncul
            $query = "INSERT INTO tentang_slider (foto, judul, status) VALUES ('$nama_baru', '$judul', 'aktif')";
            if (mysqli_query($conn, $query)) {
                // Berhasil, kembali ke halaman kelola slider dengan pesan sukses
                header("Location: ../pages/edit_profil_bidan.php?success=slider_add");
                exit();
            } else {
                echo "Database Error: " . mysqli_error($conn);
            }
        } else {
            echo "Gagal mengunggah gambar ke folder assets/slider/.";
        }
    } else {
        echo "Format file harus JPG, JPEG, atau PNG.";
    }
}
?>