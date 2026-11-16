<?php
/** @var array $pasien */
/** @var array $riwayat */
/** @var int $total */
/** @var int $selesai */
/** @var int $menunggu */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Riwayat Kunjungan | Klinik Bunanur</title>

    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">

    <style>
        .welcome-box-riwayat {
            background: linear-gradient(135deg, rgba(254, 205, 211, 0.45) 0%, rgba(255, 255, 255, 0.9) 60%, rgba(253, 242, 248, 0.6) 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 34px 38px;
            border-radius: 30px;
            color: #1e293b;
            margin-bottom: 35px;
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            box-shadow: 0 16px 40px rgba(244, 63, 94, 0.08);
            position: relative;
            overflow: hidden;
        }

        .welcome-box-riwayat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent);
        }

        .welcome-box-riwayat h3 {
            font-family: var(--font-heading);
            font-size: 26px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 8px;
        }

        .welcome-box-riwayat p {
            color: #64748b;
            font-size: 14.5px;
            margin: 0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 35px;
        }

        .info-card-riwayat {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            padding: 26px;
            border-radius: 26px;
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            box-shadow: 0 14px 35px rgba(244, 63, 94, 0.08);
            text-align: center;
            transition: all 0.35s ease;
            transform-style: preserve-3d;
        }

        .info-card-riwayat:hover {
            transform: translateY(-5px);
            border-color: rgba(244, 63, 94, 0.35);
            box-shadow: 0 18px 45px rgba(244, 63, 94, 0.16);
        }

        .info-card-riwayat i {
            font-size: 32px;
            color: var(--primary-rose);
            margin-bottom: 12px;
            display: inline-block;
        }

        .info-card-riwayat h3 {
            font-family: var(--font-heading);
            font-size: 32px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 4px;
        }

        .info-card-riwayat span {
            color: #64748b;
            font-size: 13.5px;
            font-weight: 600;
        }

        /* Modal Rating */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(24px);
            width: 90%;
            max-width: 480px;
            padding: 38px;
            border-radius: 32px;
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.35s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .modal-header h2 {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 800;
            color: #4c0519;
            margin: 0;
        }

        .btn-close-modal {
            background: #fff1f2;
            color: var(--primary-rose);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .btn-close-modal:hover {
            background: var(--primary-rose);
            color: white;
            transform: rotate(90deg);
        }

        .stars {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 20px;
        }

        .stars input { display: none; }
        .stars label { font-size: 36px; color: #cbd5e1; cursor: pointer; transition: 0.2s; }
        .stars input:checked ~ label, .stars label:hover, .stars label:hover ~ label { color: #f59e0b; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #4c0519; font-weight: 700; font-size: 14px; }
        textarea.cyber-input { resize: none; border-radius: 18px; }

        .alert-success-floating {
            position: fixed;
            top: 25px;
            right: 30px;
            z-index: 99999;
            min-width: 320px;
            max-width: 440px;
            background: #ecfdf5;
            color: #065f46;
            border: 1.5px solid rgba(16, 185, 129, 0.4);
            border-radius: 18px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.15);
            font-weight: 600;
            animation: slideRight .4s ease;
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(60px); }
            to { opacity: 1; transform: translateX(0); }
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

        .riwayat-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            margin-top: 0 !important;
            padding-top: 0 !important;
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

        @media(max-width: 900px) {
            .summary-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Interactive 3D Background Canvas -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <?= view('includes/sidebar') ?>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert-success-floating" id="successAlert">
        <i class='bx bx-check-circle' style="font-size: 24px; color: #10b981;"></i>
        <span><?= esc(session()->getFlashdata('success')); ?></span>
    </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
    <div class="alert-success-floating" id="errorAlert" style="border-left-color: #ef4444;">
        <i class='bx bx-error-circle' style="font-size: 24px; color: #ef4444;"></i>
        <span style="color: #b91c1c;"><?= esc(session()->getFlashdata('error')); ?></span>
    </div>
    <?php endif; ?>

    <div class="main">
        <div class="riwayat-container">
        <div class="topbar">
            <div>
                <h1>Riwayat Kunjungan Pasien</h1>
                <p>Halo, <?= esc($pasien['nama'] ?? 'Bunda'); ?>! Pantau jadwal dan berikan ulasan layanan klinik.</p>
            </div>
        </div>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'berhasil'): ?>
            <div class="alert-success-floating" id="successAlert">
                <i class='bx bx-check-circle' style="font-size: 24px; color: #10b981;"></i>
                <span>Terima kasih! Testimoni Anda berhasil dikirim dan akan segera tampil di beranda Klinik.</span>
            </div>
        <?php endif; ?>

        <div class="welcome-box-riwayat">
            <div class="badge-cyber badge-rose" style="margin-bottom: 12px;">
                <i class='bx bx-receipt'></i> Rekam Kunjungan Pasien
            </div>
            <h3>Pusat Rekam Medis Kunjungan</h3>
            <p>Lihat detail setiap layanan yang telah Anda terima atau bagikan ulasan berharga pengalaman Anda.</p>
        </div>

        <!-- Summary Cards with 3D Tilt -->
        <div class="summary-grid">
            <div class="info-card-riwayat glass-card-3d" data-tilt data-tilt-max="7" data-tilt-glare data-tilt-max-glare="0.10">
                <i class='bx bx-history'></i>
                <h3><?= esc((string)$total) ?></h3>
                <span>Total Kunjungan</span>
            </div>
            <div class="info-card-riwayat glass-card-3d" data-tilt data-tilt-max="7" data-tilt-glare data-tilt-max-glare="0.10">
                <i class='bx bx-check-circle' style="color: #10b981;"></i>
                <h3 style="color: #047857;"><?= esc((string)$selesai) ?></h3>
                <span>Kunjungan Selesai</span>
            </div>
            <div class="info-card-riwayat glass-card-3d" data-tilt data-tilt-max="7" data-tilt-glare data-tilt-max-glare="0.10">
                <i class='bx bx-time' style="color: #f59e0b;"></i>
                <h3 style="color: #b45309;"><?= esc((string)$menunggu) ?></h3>
                <span>Menunggu Konfirmasi</span>
            </div>
        </div>

        <!-- Tabel Aktivitas Kunjungan -->
        <div class="table-panel-cyber">
            <h3 style="font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: #4c0519; margin-bottom: 22px;">
                <i class='bx bx-list-check' style="color: var(--primary-rose);"></i> Daftar Aktivitas Kunjungan
            </h3>

            <?php if($total > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <th>Layanan Kesehatan</th>
                            <th style="text-align: center;">Status Layanan</th>
                            <th style="text-align: center;">Aksi / Ulasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($riwayat as $r): ?>
                        <?php
                        $status_raw = strtolower($r['status']);
                        $sudah_rating = ($r['sudah_rating'] ?? 0) > 0;
                        ?>
                        <tr>
                            <td>
                                <strong><?= date('d M Y', strtotime($r['tanggal'])); ?></strong>
                            </td>
                            <td>
                                <strong style="color: var(--primary-rose);"><?= htmlspecialchars($r['nama_layanan']); ?></strong>
                            </td>
                            <td align="center">
                                <?php if ($status_raw == 'menunggu'): ?>
                                    <span class="badge wait">Menunggu</span>
                                <?php elseif ($status_raw == 'disetujui'): ?>
                                    <span class="badge ok">Disetujui</span>
                                <?php else: ?>
                                    <span class="badge ok">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <?php if ($status_raw == 'selesai'): ?>
                                    <?php if ($sudah_rating): ?>
                                        <span class="badge ok">
                                            <i class='bx bx-check-circle'></i> Ulasan Terkirim
                                        </span>
                                    <?php else: ?>
                                        <button
                                            type="button"
                                            onclick="openRatingModal('<?= (int)$r['id'] ?>')"
                                            class="btn-cyber-primary"
                                            style="padding: 8px 18px; font-size: 13px;">
                                            <i class='bx bxs-star'></i> Beri Rating
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 13px; font-style: italic;">
                                        Belum Tersedia
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align:center; padding:50px 20px;">
                    <i class='bx bx-receipt' style="font-size: 50px; color: var(--primary-rose); opacity: 0.5; margin-bottom: 12px; display: block;"></i>
                    <p style="color: var(--text-muted); font-size: 15px;">Belum ada riwayat kunjungan tercatat.</p>
                </div>
            <?php endif; ?>
        </div>
        </div>
    </div>

    <!-- Modal Rating Glassmorphic -->
    <div id="modalRating" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h2>Ulasan Layanan Medis</h2>
                <button onclick="closeModal()" class="btn-close-modal"><i class='bx bx-x'></i></button>
            </div>
            
            <form action="<?= base_url('simpan-rating') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="kunjungan_id" id="modal_kunjungan_id">

                <div class="form-group">
                    <label>Berikan Rating Bintang</label>
                    <div class="stars">
                        <input type="radio" name="rating" value="5" id="s5"><label for="s5" class='bx bxs-star'></label>
                        <input type="radio" name="rating" value="4" id="s4"><label for="s4" class='bx bxs-star'></label>
                        <input type="radio" name="rating" value="3" id="s3"><label for="s3" class='bx bxs-star'></label>
                        <input type="radio" name="rating" value="2" id="s2"><label for="s2" class='bx bxs-star'></label>
                        <input type="radio" name="rating" value="1" id="s1" required><label for="s1" class='bx bxs-star'></label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Pesan & Kesan Bunda</label>
                    <textarea name="ulasan" rows="4" class="cyber-input" placeholder="Bagaimana pengalaman perawatan Bunda & Buah Hati?" required></textarea>
                </div>

                <div class="form-group">
                    <label>Foto Bukti / Momen (Opsional)</label>
                    <input type="file" name="foto" class="cyber-input" accept="image/png,image/jpeg,image/jpg" style="padding: 10px 14px; font-size: 13px;">
                </div>

                <button type="submit" class="btn-cyber-primary" style="width: 100%; padding: 14px; font-size: 15px;">
                    <i class='bx bx-paper-plane'></i> Kirim Ulasan Bunda
                </button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
    function openRatingModal(id) {
        document.getElementById('modal_kunjungan_id').value = id;
        document.getElementById('modalRating').classList.add('active');
    }

    function closeModal() {
        document.getElementById('modalRating').classList.remove('active');
    }

    window.onclick = function(event) {
        let modal = document.getElementById('modalRating');
        if (event.target == modal) closeModal();
    }

    setTimeout(function() {
        let alert = document.getElementById('successAlert');
        if (alert) {
            alert.style.transition = "0.8s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 800);
        }
    }, 6000);
    </script>
</body>
</html>
