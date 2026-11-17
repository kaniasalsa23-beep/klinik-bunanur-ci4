<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Profil & Beranda - Bunanur Medical Center</title>

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
    min-height: 100vh;
    color: #1e293b;
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
    margin-left: 260px;
    width: calc(100% - 260px);
    padding: 24px 36px 36px;
    padding-top: 24px !important;
    margin-top: 0 !important;
    min-height: 100vh;
    box-sizing: border-box;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.profil-bidan-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

@media(max-width: 992px) {
    .main { margin-left: 85px; width: calc(100% - 85px); padding: 24px 20px; padding-top: 24px !important; }
}

@media(max-width: 576px) {
    .main { margin-left: 0; width: 100%; padding: 20px 14px; padding-top: 20px !important; }
}

.topbar {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.topbar h1 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.5px;
    margin-top: 0 !important;
}

.topbar p {
    margin-top: 4px;
    margin-bottom: 30px;
    font-size: 14px;
    color: #64748b;
}

.form-box {
    max-width: 960px;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 45px;
    border-radius: 32px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
}

.avatar {
    text-align: center;
    margin-bottom: 25px;
}

.avatar img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 10px 25px rgba(244, 63, 94, 0.25);
}

.row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media(max-width: 650px) {
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
    min-height: 110px;
    resize: none;
}

.btn-primary-gradient {
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    border: none;
    padding: 16px 35px;
    border-radius: 16px;
    color: #fff;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    box-shadow: 0 10px 25px rgba(244, 63, 94, 0.3);
    transition: 0.3s;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px rgba(244, 63, 94, 0.4);
}

.alert {
    padding: 14px 20px;
    border-radius: 14px;
    margin-bottom: 25px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert.success {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #86efac;
}

.alert.error {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fca5a5;
}

/* Galeri Beranda Styling */
.galeri-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 25px;
}

.galeri-item {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    border: 1.5px solid rgba(244, 63, 94, 0.18);
    padding: 12px;
    position: relative;
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.06);
    transition: 0.3s ease;
}

.galeri-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(244, 63, 94, 0.15);
}

.galeri-item img {
    width: 100%;
    height: 135px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
}

.galeri-item .tipe-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.85);
    color: #f43f5e;
    padding: 6px;
    border-radius: 50%;
    font-size: 16px;
    backdrop-filter: blur(5px);
}

.galeri-item p {
    font-size: 13px;
    margin: 10px 0 35px;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.galeri-item .delete-btn {
    position: absolute;
    bottom: 12px;
    left: 12px;
    right: 12px;
    text-align: center;
    background: #fee2e2;
    color: #ef4444;
    border: none;
    padding: 7px 0;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: 0.2s;
}

.galeri-item .delete-btn:hover {
    background: #ef4444;
    color: white;
}

.add-galeri-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(244, 63, 94, 0.1);
    color: #f43f5e;
    padding: 10px 20px;
    border-radius: 12px;
    border: 1.5px solid rgba(244, 63, 94, 0.2);
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    cursor: pointer;
    transition: 0.3s;
}

.add-galeri-btn:hover {
    background: #f43f5e;
    color: white;
}

/* Modal Popup Tambah Galeri */
#modalGaleri {
    display: none; 
    position: fixed; 
    top: 0; left: 0; 
    width: 100%; height: 100%; 
    background: rgba(15, 23, 42, 0.6); 
    backdrop-filter: blur(8px);
    z-index: 9999; 
    justify-content: center; 
    align-items: center;
}

.modal-content {
    background: white; 
    padding: 35px; 
    border-radius: 28px; 
    width: 90%; 
    max-width: 480px; 
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar_bidan') ?>

<div class="main">
    <div class="profil-bidan-container">

    <div class="topbar">
        <h1>Edit Profil & Beranda</h1>
        <p>Kelola identitas klinis dan konten visual website utama</p>
    </div>

<div class="form-box">
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert success">
        <i class='bx bx-check-circle' style="font-size: 20px;"></i>
        <?php
        $success = session()->getFlashdata('success');
        if ($success == 'galeri_add') {
            echo "Konten slider beranda berhasil ditambahkan!";
        } elseif ($success == 'galeri_del') {
            echo "Konten slider beranda berhasil dihapus!";
        } else {
            echo "Profil bidan berhasil diperbarui secara menyeluruh.";
        }
        ?>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert error">
        <i class='bx bx-error-circle' style="font-size: 20px;"></i>
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
    <?php endif; ?>

    <!-- FORM UTAMA (Profil & Identitas) -->
    <form action="<?= site_url('update_profil_bidan') ?>"
          method="post"
          enctype="multipart/form-data">
        <?= csrf_field() ?>

        <h3 style="margin-bottom:20px; color:#f43f5e; font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px;">
            <i class='bx bx-user-circle'></i> Identitas Medis Bidan
        </h3>
        
        <div class="avatar">
            <img src="<?= !empty($bidan['foto'])
                ? base_url('assets/profile/' . $bidan['foto'])
                : base_url('assets/profile/default.png') ?>"
                 alt="Profile Bidan">
        </div>

        <div class="group">
            <label>Ganti Foto Profil Utama</label>
            <input type="file" name="foto" accept="image/*">
        </div>

        <div class="row">
            <div class="group">
                <label>Nama Lengkap & Gelar</label>
                <input type="text"
                       name="nama"
                       value="<?= esc($bidan['nama'] ?? '') ?>"
                       required>
            </div>

            <div class="group">
                <label>Username Petugas</label>
                <input type="text"
                       name="username"
                       value="<?= esc($bidan['username'] ?? '') ?>"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="group">
                <label>Alamat Email</label>
                <input type="email"
                       name="email"
                       value="<?= esc($bidan['email'] ?? '') ?>"
                       required>
            </div>

            <div class="group">
                <label>No. WhatsApp Aktif</label>
                <input type="text"
                       name="whatsapp"
                       value="<?= esc($bidan['whatsapp'] ?? '') ?>"
                       placeholder="Masukkan Nomor WhatsApp Terdaftar"
                       required>
            </div>
        </div>

        <div class="row">
            <div class="group">
                <label>Spesialisasi / Gelar Profesi</label>
                <input type="text"
                       name="spesialis"
                       value="<?= esc($bidan['spesialis'] ?? '') ?>">
            </div>

            <div class="group">
                <label>Kata Sandi Baru (Kosongkan jika tetap)</label>
                <input type="password"
                       name="password"
                       placeholder="••••••••">
            </div>
        </div>

        <div class="row">
            <div class="group">
                <label><i class='bx bxl-instagram'></i> Akun Instagram</label>
                <input type="text"
                       name="instagram"
                       value="<?= esc($bidan['instagram'] ?? '') ?>"
                       placeholder="@username">
            </div>

            <div class="group">
                <label><i class='bx bxl-facebook-circle'></i> Halaman Facebook</label>
                <input type="text"
                       name="facebook"
                       value="<?= esc($bidan['facebook'] ?? '') ?>"
                       placeholder="Nama Halaman">
            </div>
        </div>

        <div class="group">
            <label><i class='bx bxl-tiktok'></i> Akun TikTok</label>
            <input type="text"
                   name="tiktok"
                   value="<?= esc($bidan['tiktok'] ?? '') ?>"
                   placeholder="@tiktok">
        </div>

        <div class="group">
            <label><i class='bx bx-map-pin'></i> Alamat Fisik Klinik</label>
            <textarea name="alamat"
                      style="min-height:90px;"
                      placeholder="Masukkan alamat lengkap lokasi klinik..."><?= esc($bidan['alamat'] ?? '') ?></textarea>
        </div>

        <div class="group">
            <label>Biografi Singkat (Profil Singkat)</label>
            <textarea name="tentang"
                      placeholder="Tuliskan pengalaman klinis dan sambutan untuk pasien..."><?= esc($bidan['tentang'] ?? '') ?></textarea>
        </div>

        <hr style="margin:40px 0; border:0; border-top:1.5px dashed rgba(244, 63, 94, 0.2);">

        <h3 style="margin-bottom:20px; color:#f43f5e; font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px;">
            <i class='bx bx-home-heart'></i> Konfigurasi Tampilan Halaman Utama Pasien
        </h3>

        <div class="group">
            <label>Judul Utama Beranda (Hero Title)</label>
            <input type="text"
                   name="hero_judul"
                   value="<?= esc($bidan['hero_judul'] ?? '') ?>"
                   required>
        </div>

        <div class="group">
            <label>Slogan Promosi (Hero Subtitle)</label>
            <textarea name="hero_subjudul"
                      style="min-height:80px;"><?= esc($bidan['hero_subjudul'] ?? '') ?></textarea>
        </div>

        <div class="group">
            <label>Visi & Misi Klinik</label>
            <textarea name="deskripsi_beranda"><?= esc($bidan['deskripsi_beranda'] ?? '') ?></textarea>
        </div>

        <div class="group">
            <label>Banner Foto Seksi "Tentang Kami"</label>
            <input type="file" name="foto_tentang" accept="image/*">
        </div>

        <?php if (!empty($bidan['foto_tentang'])): ?>
            <div class="group"
                 style="background: rgba(244, 63, 94, 0.04);
                        padding: 20px;
                        border-radius: 20px;
                        text-align: center;
                        border: 1.5px solid rgba(244, 63, 94, 0.16);
                        margin-bottom: 20px;">
                <label style="color: #f43f5e;">
                    Preview Banner Saat Ini
                </label>
                <img src="<?= base_url('assets/profile/' . $bidan['foto_tentang']) ?>"
                     style="width: 280px;
                            border-radius: 14px;
                            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
                            margin-top: 10px;
                            border: 2px solid white;">
            </div>
        <?php endif; ?>

        <button type="submit" name="simpan" value="1" class="btn-primary-gradient">
            <i class='bx bx-save'></i> Simpan Semua Perubahan Profil & Beranda
        </button>
    </form>

    <!-- SECTION GALERI SLIDER -->
    <hr style="margin:45px 0; border:0; border-top:1.5px dashed rgba(244, 63, 94, 0.2);">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
        <h3 style="color:#f43f5e; font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px;">
            <i class='bx bx-images'></i> Dokumentasi Pelayanan & Slider Beranda
        </h3>

        <button type="button"
                class="add-galeri-btn"
                onclick="openModalGaleri()">
            <i class='bx bx-plus-circle'></i> Tambah Konten Baru
        </button>
    </div>

    <div class="galeri-list">
    <?php if (!empty($galeri)): ?>
        <?php foreach ($galeri as $g): ?>
            <div class="galeri-item">
                <i class='tipe-icon bx <?= ($g['tipe'] === 'foto') ? 'bx-image' : 'bx-video' ?>'></i>

                <?php if ($g['tipe'] === 'foto'): ?>
                    <?php
                    $gambarPath = FCPATH . 'assets/slider/' . $g['file_name'];
                    ?>
                    <img
                        src="<?= file_exists($gambarPath)
                            ? base_url('assets/slider/' . $g['file_name'])
                            : base_url('assets/profile/default.png') ?>"
                        alt="<?= esc($g['judul']) ?>">
                <?php else: ?>
                    <div style="
                        height:135px;
                        background:rgba(244, 63, 94, 0.08);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        border-radius:14px;">
                        <i class='bx bx-play-circle' style="font-size:44px; color:#f43f5e;"></i>
                    </div>
                <?php endif; ?>

                <p><?= esc($g['judul']) ?></p>

                <a href="<?= site_url('hapus_galeri/' . $g['id']) ?>"
                   class="delete-btn"
                   onclick="return confirm('Hapus konten ini dari slider beranda?')">
                    <i class='bx bx-trash'></i> Hapus
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column:1/-1; text-align:center; padding:40px; border:2px dashed rgba(244, 63, 94, 0.2); border-radius:20px; color:#94a3b8;">
            Belum ada dokumentasi pelayanan di galeri slider.
        </div>
    <?php endif; ?>
    </div>
</div>
</div>
</div>

<!-- Modal Popup Tambah Galeri -->
<div id="modalGaleri">
    <div class="modal-content">
        <h3 style="margin-bottom:20px; color:#1e293b; font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px;">
            <i class='bx bx-plus-circle' style="color:#f43f5e;"></i> Tambah Dokumentasi Slider
        </h3>
        
        <form action="<?= site_url('tambah_galeri') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="group" style="margin-bottom:15px;">
                <label>Judul Kegiatan / Layanan</label>
                <input type="text" name="judul_galeri" placeholder="Judul Dokumentasi Layanan / Galeri">
            </div>
            
            <div class="group" style="margin-bottom:15px;">
                <label>Tipe Berkas</label>
                <select name="tipe" required>
                    <option value="foto">Foto Dokumentasi</option>
                    <option value="video">Video Dokumentasi</option>
                </select>
            </div>

            <div class="group" style="margin-bottom:20px;">
                <label>Pilih File Foto/Video (Maks. 2MB)</label>
                <input type="file" name="galeri" accept="image/*,video/*" required>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" name="tambah_galeri" class="btn-primary-gradient" style="flex:1;">
                    Unggah Berkas
                </button>
                <button type="button" onclick="closeModalGaleri()" style="flex:1; background:#f1f5f9; color:#64748b; border:none; border-radius:14px; font-weight:700; cursor:pointer;">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
function openModalGaleri() {
    document.getElementById('modalGaleri').style.display = 'flex';
}

function closeModalGaleri() {
    document.getElementById('modalGaleri').style.display = 'none';
}

window.onclick = function(event) {
    let modal = document.getElementById('modalGaleri');
    if (event.target == modal) {
        closeModalGaleri();
    }
}
</script>
</body>
</html>
