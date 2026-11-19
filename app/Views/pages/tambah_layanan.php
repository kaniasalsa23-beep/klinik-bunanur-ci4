<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan Baru - Bunanur Medical Center</title>

    <!-- Master Glassmorphism 3D CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
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

        @media (max-width: 992px) {
            .main { margin-left: 85px !important; width: calc(100% - 85px) !important; padding: 24px 20px !important; padding-top: 24px !important; }
        }
        @media (max-width: 576px) {
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

        /* Modern Form Card */
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

        .form-row { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 20px; 
        }

        @media(max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
        }

        .group { margin-bottom: 20px; }
        
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

        /* Custom File Upload */
        .file-box {
            border: 2px dashed rgba(244, 63, 94, 0.25);
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            background: rgba(244, 63, 94, 0.03);
        }

        .file-box:hover { 
            border-color: #f43f5e; 
            background: rgba(244, 63, 94, 0.06); 
        }

        .file-box i { 
            font-size: 38px; 
            color: #f43f5e; 
            margin-bottom: 8px; 
        }

        .file-box p {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }

        .btn-save {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            color: white;
            border: none;
            padding: 16px 35px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 15px;
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

        .btn-save:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 14px 32px rgba(244, 63, 94, 0.4); 
        }

        .alert-error { 
            padding: 14px 20px; 
            border-radius: 14px; 
            margin-bottom: 20px; 
            font-size: 13px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            background: #fee2e2; 
            color: #b91c1c; 
            border: 1px solid #fca5a5; 
            font-weight: 600;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="cyberCanvas"></canvas>

<?= view('includes/sidebar_bidan') ?>

<main class="main">
    <div class="topbar">
        <div class="breadcrumb">
            <a href="<?= site_url('kelola_layanan') ?>">Kelola Layanan</a>
            <i class='bx bx-chevron-right'></i>
            <span>Tambah Layanan Baru</span>
        </div>
        <h1>Tambah Layanan Medis</h1>
        <p>Formulir penambahan data paket layanan kesehatan Klinik Bunanur</p>
    </div>

    <div class="form-box">
        <a href="<?= site_url('kelola_layanan') ?>" class="back-btn">
            <i class='bx bx-left-arrow-alt'></i> Kembali ke Daftar Layanan
        </a>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <i class='bx bx-error-circle' style="font-size: 20px;"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('tambah_layanan') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="group">
                <label>Nama Layanan Medis</label>
                <input type="text" name="nama" placeholder="Nama Layanan Medis (ANC, Imunisasi, Baby Spa, dll)" required>
            </div>

            <div class="group">
                <label>Deskripsi & Manfaat Layanan</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan secara mendalam manfaat klinis dan detail prosedur layanan..." required></textarea>
            </div>

            <div class="form-row">
                <div class="group">
                    <label>Kategori Pasien</label>
                    <select name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Bayi">Bayi</option>
                    </select>
                </div>
                <div class="group">
                    <label>Estimasi Durasi Layanan</label>
                    <input type="text" name="durasi" placeholder="Misal: 45 Menit" required>
                </div>
            </div>

            <div class="form-row">
                <div class="group">
                    <label>Tarif / Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="0" required min="0">
                </div>
                <div class="group">
                    <label>Status Publikasi</label>
                    <select name="status">
                        <option value="aktif">Aktif (Tampilkan di Katalog Pasien)</option>
                        <option value="nonaktif">Nonaktif (Simpan sebagai Draft)</option>
                    </select>
                </div>
            </div>

            <div class="group">
                <label>Foto Cover Layanan</label>
                <div class="file-box" onclick="document.getElementById('file-input').click()">
                    <i class='bx bx-cloud-upload'></i>
                    <p id="file-name">Klik untuk mengunggah foto promosi layanan</p>
                    <input type="file" name="gambar" id="file-input" hidden accept="image/*" 
                           onchange="document.getElementById('file-name').innerText = this.files[0].name">
                </div>
            </div>

            <button type="submit" name="simpan" class="btn-save">
                <i class='bx bx-check-double'></i> Simpan Data Layanan Medis
            </button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
</body>
</html>
