<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Layanan - Bunanur Medical Center</title>

<!-- Master Glassmorphism 3D CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
    color: #1e293b;
    display: flex;
    min-height: 100vh;
}

#cyberCanvas {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: -1 !important;
    pointer-events: none !important;
}

.main {
    margin-left: 260px !important;
    width: calc(100% - 260px) !important;
    padding: 24px 36px 36px !important;
    padding-top: 24px !important;
    margin-top: 0 !important;
    min-height: 100vh;
    box-sizing: border-box !important;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.topbar {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.topbar h1 {
    margin-top: 0 !important;
}

@media(max-width: 992px) {
    .main { margin-left: 85px !important; width: calc(100% - 85px) !important; padding: 24px 20px !important; padding-top: 24px !important; }
}

@media(max-width: 576px) {
    .main { margin-left: 0 !important; width: 100% !important; padding: 20px 14px !important; padding-top: 20px !important; }
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 12px;
}

.breadcrumb a {
    text-decoration: none;
    color: #f43f5e;
}

.breadcrumb span {
    color: #94a3b8;
}

.topbar h1 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.5px;
}

.topbar p {
    font-size: 14px;
    color: #64748b;
    margin-top: 4px;
    margin-bottom: 30px;
}

.form-box {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 40px;
    border-radius: 30px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
    max-width: 900px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #f1f5f9;
    border-radius: 12px;
    text-decoration: none;
    color: #475569;
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 25px;
    transition: 0.3s;
}

.back-btn:hover {
    background: #e2e8f0;
    color: #1e293b;
}

.preview-wrap {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(244, 63, 94, 0.03);
    border: 1.5px dashed rgba(244, 63, 94, 0.2);
    border-radius: 24px;
}

.preview-img {
    width: 100%;
    max-width: 380px;
    height: 240px;
    object-fit: cover;
    border-radius: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
    border: 3px solid white;
}

.row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media(max-width: 600px) {
    .row { grid-template-columns: 1fr; }
}

.group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
}

input, textarea, select {
    width: 100%;
    padding: 14px 18px;
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.9);
    font-family: inherit;
    font-size: 14px;
    color: #1e293b;
    outline: none;
    transition: 0.3s;
}

input:focus, textarea:focus, select:focus {
    border-color: #f43f5e;
    background: white;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
}

textarea {
    min-height: 120px;
    resize: none;
}

.btn-update {
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    border: none;
    padding: 16px 35px;
    border-radius: 16px;
    color: white;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    width: 100%;
    margin-top: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 10px 25px rgba(244, 63, 94, 0.3);
    transition: 0.3s;
}

.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px rgba(244, 63, 94, 0.4);
}

.alert-error {
    padding: 14px 20px;
    border-radius: 14px;
    margin-bottom: 20px;
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fca5a5;
    font-size: 13px;
    font-weight: 600;
}
</style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="cyberCanvas"></canvas>

<?= view('includes/sidebar_bidan') ?>

<div class="main">

    <div class="topbar">
        <div class="breadcrumb">
            <a href="<?= site_url('kelola_layanan') ?>">Kelola Layanan</a>
            <i class='bx bx-chevron-right'></i>
            <span>Edit Layanan</span>
        </div>
        <h1>Edit Data Layanan Medis</h1>
        <p>Perbarui informasi tarif, durasi, deskripsi, dan foto layanan</p>
    </div>

    <div class="form-box">
        <a href="<?= site_url('kelola_layanan') ?>" class="back-btn">
            <i class='bx bx-left-arrow-alt'></i> Kembali ke Daftar Layanan
        </a>

        <?php if (!empty($error)) : ?>
            <div class="alert-error">
                <i class='bx bx-error-circle'></i> <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('edit_layanan/' . ($data['id'] ?? 0)) ?>"
              method="post"
              enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="preview-wrap">
                <p style="font-size: 13px; font-weight: 700; color: #64748b; margin-bottom: 12px; text-transform: uppercase;">
                    Foto Layanan Saat Ini
                </p>
                <img src="<?= base_url('assets/layanan/' . ($data['gambar'] ?? 'default.png')) ?>" class="preview-img" alt="Foto Layanan">
            </div>

            <div class="group">
                <label>Nama Layanan Medis</label>
                <input
                    type="text"
                    name="nama"
                    value="<?= esc($data['nama_layanan'] ?? '') ?>"
                    required>
            </div>

            <div class="row">
                <div class="group">
                    <label>Kategori Pasien</label>
                    <select name="kategori">
                        <option value="ibu" <?= (($data['kategori'] ?? '') == 'ibu') ? 'selected' : '' ?>>Ibu</option>
                        <option value="bayi" <?= (($data['kategori'] ?? '') == 'bayi') ? 'selected' : '' ?>>Bayi</option>
                    </select>
                </div>

                <div class="group">
                    <label>Durasi Pelayanan</label>
                    <input
                        type="text"
                        name="durasi"
                        value="<?= esc($data['durasi'] ?? '') ?>"
                        required>
                </div>
            </div>

            <div class="group">
                <label>Deskripsi & Prosedur Medis</label>
                <textarea
                    name="deskripsi"
                    rows="4"
                    required><?= esc($data['deskripsi'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="group">
                    <label>Tarif / Harga (Rp)</label>
                    <input
                        type="number"
                        name="harga"
                        value="<?= esc($data['harga'] ?? '') ?>"
                        required min="0">
                </div>

                <div class="group">
                    <label>Status Publikasi</label>
                    <select name="status">
                        <option value="aktif" <?= (($data['status'] ?? '') == 'aktif') ? 'selected' : '' ?>>
                            Aktif (Tampilkan di Katalog)
                        </option>
                        <option value="nonaktif" <?= (($data['status'] ?? '') == 'nonaktif') ? 'selected' : '' ?>>
                            Nonaktif (Draft)
                        </option>
                    </select>
                </div>
            </div>

            <div class="group">
                <label>Ganti Foto Cover Layanan (Kosongkan jika tidak diubah)</label>
                <input
                    type="file"
                    name="gambar"
                    accept="image/*">
            </div>

            <button type="submit" name="update" class="btn-update">
                <i class='bx bx-save'></i> Simpan Pembaruan Layanan
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
setInterval(function(){
    fetch('<?= site_url('bidan/updateLastSeen') ?>');
}, 5000);
</script>
</body>
</html>
