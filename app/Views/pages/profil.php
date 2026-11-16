<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pasien - Bunanur Medical</title>
    
    <!-- Master Glassmorphism 3D CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" rel="stylesheet"/>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
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

        .profil-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        @media (max-width: 992px) {
            .main { margin-left: 85px; width: calc(100% - 85px); padding: 24px 20px; padding-top: 24px !important; }
        }
        @media (max-width: 576px) {
            .main { margin-left: 0; width: 100%; padding: 20px 14px; padding-top: 20px !important; }
        }

        .topbar {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .topbar h2 {
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.5px;
            margin-top: 0 !important;
        }

        .topbar p {
            font-size: 14px;
            color: #64748b;
            margin-top: 4px;
            margin-bottom: 25px;
        }

        /* Banner Welcome */
        .welcome-box {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            padding: 30px 35px;
            border-radius: 26px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 15px 30px -5px rgba(244, 63, 94, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-box::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            top: -100px;
            right: -60px;
            pointer-events: none;
        }

        .welcome-box h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .welcome-box p {
            font-size: 14px;
            opacity: 0.95;
            line-height: 1.5;
        }

        /* Kontainer Utama Dua Kolom */
        .exclusive-card {
            display: flex;
            gap: 40px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
            align-items: flex-start;
        }

        /* Bagian Foto (Kiri) */
        .profile-aside {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 1.5px solid rgba(244, 63, 94, 0.12);
            padding-right: 40px;
        }

        .avatar-wrapper {
            position: relative;
            width: 170px;
            height: 170px;
            margin-bottom: 22px;
        }

        .avatar-main {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.2);
        }

        .btn-camera {
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 18px rgba(244, 63, 94, 0.25);
        }

        .btn-camera:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(244, 63, 94, 0.35);
        }

        /* Bagian Form (Kanan) */
        .profile-form-area {
            flex: 2.5;
            width: 100%;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field-group.full { grid-column: span 2; }

        .field-group label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 4px;
        }

        .form-input {
            padding: 14px 18px;
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            border-radius: 14px;
            font-family: inherit;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.9);
            color: #1e293b;
            transition: 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #f43f5e;
            background: white;
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
        }

        textarea.form-input { min-height: 100px; resize: none; }

        .btn-submit {
            margin-top: 25px;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 24px rgba(244, 63, 94, 0.28);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(244, 63, 94, 0.38);
        }

        /* Danger Zone */
        .danger-zone {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1.5px solid rgba(244, 63, 94, 0.12);
            text-align: center;
            width: 100%;
        }

        .danger-text {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 12px;
            display: block;
        }

        .btn-delete {
            background: transparent;
            border: 1.5px solid #ef4444;
            color: #ef4444;
            padding: 8px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.25);
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border-left: 4px solid #10b981;
            padding: 14px 20px;
            margin-bottom: 25px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.1);
        }

        /* Modal Crop */
        .modal {
            display: none; 
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); 
            backdrop-filter: blur(8px);
            justify-content: center; 
            align-items: center; 
            z-index: 9999;
        }
        .modal-box { 
            background: white; 
            padding: 30px; 
            border-radius: 28px; 
            width: 90%; 
            max-width: 480px; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .crop-container { max-height: 380px; overflow: hidden; border-radius: 16px; }
        .modal-actions { display: flex; gap: 12px; margin-top: 22px; }
        .modal-actions button { 
            flex: 1; 
            padding: 12px; 
            border-radius: 12px; 
            border: none; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 14px; 
        }
        .save-btn { 
            background: linear-gradient(135deg, #f43f5e, #ec4899); 
            color: white; 
            box-shadow: 0 6px 18px rgba(244, 63, 94, 0.25);
        }
        .cancel-btn { background: #f1f5f9; color: #64748b; }

        @media (max-width: 992px) {
            .exclusive-card { flex-direction: column; align-items: center; }
            .profile-aside { border-right: none; border-bottom: 1.5px solid rgba(244, 63, 94, 0.12); padding-right: 0; padding-bottom: 30px; width: 100%; }
            .form-grid { grid-template-columns: 1fr; }
            .field-group.full { grid-column: span 1; }
        }
    </style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar') ?>

<div class="main">
    <div class="profil-container">
    <div class="topbar">
        <h2>Profil Pasien</h2>
        <p>Perbarui informasi akun dan identitas medis Anda</p>
    </div>

    <div class="welcome-box">
        <h3>Pengaturan Profil & Akun</h3>
        <p>Pastikan data pribadi dan kontak darurat Anda selalu akurat untuk kenyamanan pelayanan medis.</p>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert-success">
        <i class='bx bx-check-circle' style="font-size: 20px;"></i>
        <?= esc(session()->getFlashdata('success')); ?>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626; padding: 14px 18px; border-radius: 14px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
        <i class='bx bx-error-circle' style="font-size: 20px;"></i>
        <?= esc(session()->getFlashdata('error')); ?>
    </div>
    <?php endif; ?>

    <div class="exclusive-card">
        <!-- Kolom Foto -->
        <aside class="profile-aside">
            <div class="avatar-wrapper">
                <img id="preview"
                     src="<?= base_url('assets/profile/' . (!empty($pasien['foto']) ? $pasien['foto'] : 'default.png')) ?>"
                     class="avatar-main"
                     alt="Foto Profil">
            </div>
            <button type="button" class="btn-camera" onclick="pilihFoto()">
                <i class='bx bx-camera'></i> Ganti Foto Profil
            </button>
            <input type="file" id="fotoInput" accept="image/*" hidden>
        </aside>

        <!-- Kolom Form -->
        <main class="profile-form-area">
            <form action="<?= base_url('profil/update') ?>"
                  method="post"
                  enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="foto_base64" id="foto_base64">
                
                <div class="form-grid">
                    <div class="field-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-input" value="<?= esc($pasien['nama'] ?? ''); ?>" required>
                    </div>

                    <div class="field-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-input" value="<?= esc($pasien['username'] ?? ''); ?>" required>
                    </div>

                    <div class="field-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-input" value="<?= esc($pasien['email'] ?? ''); ?>">
                    </div>

                    <div class="field-group">
                        <label>No. HP (WhatsApp)</label>
                        <input type="text" name="no_hp" class="form-input" value="<?= esc($pasien['no_hp'] ?? ''); ?>">
                    </div>

                    <div class="field-group full">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" class="form-input"><?= esc($pasien['alamat'] ?? ''); ?></textarea>
                    </div>

                    <div class="field-group full">
                        <label>Password Baru (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-submit" name="update">
                    <i class='bx bx-save'></i> Simpan Perubahan Profil
                </button>
            </form>

            <div class="danger-zone">
                <span class="danger-text">
                    Ingin berhenti menggunakan layanan kami?
                </span>
                <form action="<?= base_url('hapus_akun') ?>" method="post">
                    <?= csrf_field() ?>
                    <button
                        type="submit"
                        name="delete_account"
                        class="btn-delete"
                        onclick="return confirm('PERINGATAN: Akun Anda akan dihapus secara permanen beserta seluruh riwayat. Lanjutkan?')">
                        <i class='bx bx-trash'></i> Hapus Akun Permanen
                    </button>
                </form>
            </div>
        </main>
    </div>
    </div>
</div>

<!-- Modal Crop -->
<div class="modal" id="cropModal">
    <div class="modal-box">
        <h3 style="margin-bottom: 18px; text-align: center; font-size: 18px; font-weight: 800; color: #1e293b;">Sesuaikan Foto Profil</h3>
        <div class="crop-container">
            <img id="imageToCrop" style="max-width: 100%;">
        </div>
        <div class="modal-actions">
            <button class="save-btn" onclick="cropImage()">Gunakan Foto Ini</button>
            <button class="cancel-btn" onclick="closeCrop()">Batal</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
    let cropper;

    function pilihFoto() {
        document.getElementById('fotoInput').click();
    }

    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('cropModal').style.display = 'flex';
            let img = document.getElementById('imageToCrop');
            img.src = ev.target.result;

            if (cropper) cropper.destroy();
            cropper = new Cropper(img, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1
            });
        }
        reader.readAsDataURL(file);
    });

    function cropImage() {
        let canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
        let cropped = canvas.toDataURL('image/png');
        document.getElementById('preview').src = cropped;
        document.getElementById('foto_base64').value = cropped;
        closeCrop();
    }

    function closeCrop() {
        document.getElementById('cropModal').style.display = 'none';
        if (cropper) cropper.destroy();
    }
</script>

</body>
</html>
