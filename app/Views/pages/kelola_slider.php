<?php
include 'config/koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM tentang_slider ORDER BY id DESC");
?>

<div class="container mt-4">
    <h3>Kelola Slider Beranda</h3>
    <!-- Form Tambah -->
    <form action="proses/tambah_slider.php" method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="input-group">
            <input type="file" name="foto" class="form-control" required>
            <button class="btn btn-primary" type="submit" name="simpan">Upload Gambar</button>
        </div>
        <small class="text-muted">Format: JPG/PNG, Max: 2MB. Akan muncul di slider utama.</small>
    </form>

    <!-- Tabel List Slider -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><img src="assets/slider/<?= $row['foto']; ?>" width="100"></td>
                <td>
                    <a href="proses/hapus_slider.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus gambar ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>