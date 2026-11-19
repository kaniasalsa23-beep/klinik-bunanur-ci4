<?php
/**
 * @var int $pending
 * @var int $approved
 * @var int $total_testi
 * @var array $testimoni
 */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Validasi & Publish Testimoni - Bunanur Medical Center</title>

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

    .testimoni-container {
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

    .topbar { margin-top: 0 !important; padding-top: 0 !important; margin-bottom: 30px; }
    .topbar h1 { 
        font-size: 28px; 
        font-weight: 800; 
        color: #1e293b; 
        letter-spacing: -0.5px; 
        margin-top: 0 !important;
    }
    .topbar p { font-size: 14px; color: #64748b; margin-top: 4px; }

    /* STATS CARDS */
    .stats { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px; 
    }
    .card { 
        background: rgba(255, 255, 255, 0.85); 
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1.5px solid rgba(244, 63, 94, 0.16);
        padding: 24px; 
        border-radius: 24px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        box-shadow: 0 10px 25px rgba(244, 63, 94, 0.06);
        transition: all 0.3s ease;
    }
    .card:hover { 
        transform: translateY(-4px); 
        box-shadow: 0 15px 35px rgba(244, 63, 94, 0.12); 
    }
    .card-info h3 { font-size: 30px; font-weight: 800; color: #1e293b; line-height: 1; }
    .card-info p { font-size: 13px; color: #64748b; font-weight: 600; margin-top: 6px; }
    .card i { 
        font-size: 38px; 
        padding: 12px; 
        border-radius: 18px; 
    }

    /* TABLE BOX */
    .table-box { 
        background: rgba(255, 255, 255, 0.88); 
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1.5px solid rgba(244, 63, 94, 0.16);
        padding: 30px; 
        border-radius: 28px; 
        box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
        overflow-x: auto;
    }

    .table-box h3 { 
        margin-bottom: 20px; 
        font-size: 18px; 
        color: #1e293b; 
        font-weight: 800;
    }

    table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0;
    }

    thead tr th {
        padding: 14px 16px; 
        color: white;
        background: linear-gradient(135deg, #f43f5e, #ec4899); 
        font-weight: 700;
        font-size: 13px;
        text-align: left;
    }

    thead tr th:first-child { border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    thead tr th:last-child { border-top-right-radius: 14px; border-bottom-right-radius: 14px; text-align: center; }

    td { 
        padding: 18px 16px; 
        border-bottom: 1px solid rgba(244, 63, 94, 0.08); 
        vertical-align: middle;
        color: #334155;
        font-size: 13px;
    }

    .btn-upload {
        background: #10b981; 
        color: white; 
        padding: 8px 18px; 
        border-radius: 12px;
        text-decoration: none; 
        font-size: 12px; 
        font-weight: 700; 
        transition: 0.3s;
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
        border: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }
    .btn-upload:hover { 
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); 
    }

    .btn-unpublish {
        background: #f59e0b;
        color: white;
        padding: 6px 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: none;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.25);
    }
    .btn-unpublish:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(245, 158, 11, 0.35);
    }

    .btn-delete-testi {
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: none;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
    }
    .btn-delete-testi:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.35);
    }

    .status-selesai { 
        color: #15803d; 
        font-weight: 700; 
        font-size: 11px; 
        background: #dcfce7; 
        padding: 6px 14px; 
        border-radius: 30px;
        display: inline-flex; 
        align-items: center; 
        gap: 5px;
    }

    .img-thumb { 
        width: 52px; 
        height: 52px; 
        object-fit: cover; 
        border-radius: 12px; 
        border: 2px solid #fff; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        cursor: pointer; 
        transition: 0.3s ease; 
    }
    .img-thumb:hover { 
        transform: scale(1.1); 
        border-color: #f43f5e; 
    }

    #fotoModal {
        display: none; 
        position: fixed; 
        z-index: 10000; 
        left: 0; top: 0; 
        width: 100%; height: 100%; 
        background: rgba(15, 23, 42, 0.7); 
        backdrop-filter: blur(8px);
        justify-content: center; 
        align-items: center;
    }
</style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>
<body>
    
    <!-- 3D Canvas Background -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

    <?= view('includes/sidebar_bidan') ?>

    <div class="main">
        <div class="testimoni-container">
        <div class="topbar">
            <h1>Validasi & Publikasi Testimoni</h1>
            <p>Pilih dan tampilkan ulasan terbaik pasien di etalase website utama</p>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
        <div style="background:#dcfce7; color:#15803d; border-left:4px solid #10b981; padding:14px 20px; border-radius:14px; margin-bottom:25px; font-weight:600; font-size:14px;">
            <i class='bx bx-check-circle'></i> <?= esc(session()->getFlashdata('success')) ?>
        </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
        <div style="background:#fee2e2; color:#b91c1c; border-left:4px solid #ef4444; padding:14px 20px; border-radius:14px; margin-bottom:25px; font-weight:600; font-size:14px;">
            <i class='bx bx-error-circle'></i> <?= esc(session()->getFlashdata('error')) ?>
        </div>
        <?php endif; ?>

        <div class="stats">
            <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
                <div class="card-info"><h3><?= esc((string)$pending) ?></h3><p>Perlu Validasi</p></div>
                <i class='bx bx-time-five' style="color: #f59e0b; background: rgba(245, 158, 11, 0.1);"></i>
            </div>
            <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
                <div class="card-info"><h3><?= esc((string)$approved) ?></h3><p>Sudah Terbit</p></div>
                <i class='bx bx-cloud-upload' style="color: #10b981; background: rgba(16, 185, 129, 0.1);"></i>
            </div>
            <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
                <div class="card-info"><h3><?= esc((string)$total_testi) ?></h3><p>Total Ulasan Masuk</p></div>
                <i class='bx bx-star' style="color: #f43f5e; background: rgba(244, 63, 94, 0.1);"></i>
            </div>
        </div>

        <div class="table-box">
            <h3>Daftar Ulasan Pasien Masuk</h3>
            <table>
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Penilaian</th>
                        <th>Ulasan / Komentar</th>
                        <th>Bukti Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($testimoni)): ?>
                    <?php foreach ($testimoni as $r): ?>
                        <tr>
                            <td style="font-weight:700; color:#1e293b;">
                                <?= esc($r['nama_pasien'] ?? 'Pasien Anonim') ?>
                            </td>
                            <td>
                                <div style="color: #f59e0b; font-size: 16px; display: flex; gap: 2px;">
                                    <?php 
                                        for($i=1; $i<=5; $i++){
                                            echo ($i <= $r['rating']) ? "<i class='bx bxs-star'></i>" : "<i class='bx bx-star' style='color:#cbd5e1'></i>";
                                        }
                                    ?>
                                </div>
                            </td>
                            <td style="max-width:320px; line-height:1.6;">
                                <span style="font-size: 13px; color: #475569;">
                                    "<?= esc($r['ulasan']) ?>"
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($r['foto'])): ?>
                                    <img
                                        src="<?= base_url('assets/testimoni/' . $r['foto']) ?>"
                                        class="img-thumb"
                                        alt="Bukti Foto"
                                        onclick="openModal(this.src)">
                                <?php else: ?>
                                    <i class='bx bx-image-alt' style="font-size: 26px; color: #cbd5e1;"></i>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <div style="display:flex; justify-content:center; align-items:center; gap:6px; flex-wrap:wrap;">
                                    <?php if($r['approve'] == 'Menunggu'): ?>
                                        <a href="<?= site_url('testimoni/publish/' . (int)$r['id']) ?>"
                                           class="btn-upload"
                                           onclick="return confirm('Publikasikan testimoni ini ke beranda utama?')">
                                            <i class='bx bx-cloud-upload'></i> Terbitkan
                                        </a>
                                        <a href="<?= site_url('testimoni/hapus/' . (int)$r['id']) ?>"
                                           class="btn-delete-testi"
                                           onclick="return confirm('Hapus testimoni ini secara permanen?')">
                                            <i class='bx bx-trash'></i> Hapus
                                        </a>
                                    <?php else: ?>
                                        <span class="status-selesai">
                                            <i class='bx bx-check-shield'></i> Telah Terbit
                                        </span>
                                        <a href="<?= site_url('testimoni/unpublish/' . (int)$r['id']) ?>"
                                           class="btn-unpublish"
                                           title="Tarik dari Beranda"
                                           onclick="return confirm('Tarik kembali testimoni ini dari publikasi beranda?')">
                                            <i class='bx bx-undo'></i> Tarik
                                        </a>
                                        <a href="<?= site_url('testimoni/hapus/' . (int)$r['id']) ?>"
                                           class="btn-delete-testi"
                                           title="Hapus Testimoni"
                                           onclick="return confirm('Hapus testimoni ini secara permanen?')">
                                            <i class='bx bx-trash'></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5" style="padding: 50px; color: #94a3b8; text-align: center;">Belum ada testimoni pasien yang masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>

    <div id="fotoModal" onclick="this.style.display='none'">
        <img id="imgFull" src="" style="max-width:90%; max-height:85vh; border-radius:20px; border: 4px solid white; box-shadow:0 25px 50px rgba(0,0,0,0.5);">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
    <script>
        function openModal(src) {
            document.getElementById('fotoModal').style.display = "flex";
            document.getElementById('imgFull').src = src;
        }
    </script>

    <!-- Mobile Sidebar Toggle -->
    <script>
    (function(){
        var toggle = document.querySelector('.sidebar-mobile-toggle');
        var sidebar = document.querySelector('.sidebar, .sidebar-container');
        var backdrop = document.querySelector('.sidebar-backdrop');
        if (!toggle) {
            toggle = document.createElement('button');
            toggle.className = 'sidebar-mobile-toggle';
            toggle.innerHTML = '<i class="bx bx-menu"></i>';
            document.body.appendChild(toggle);
        }
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.className = 'sidebar-backdrop';
            document.body.appendChild(backdrop);
        }
        function openSidebar(){
            if(sidebar) sidebar.classList.add('mobile-open');
            backdrop.classList.add('active');
            toggle.innerHTML = '<i class="bx bx-x"></i>';
        }
        function closeSidebar(){
            if(sidebar) sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('active');
            toggle.innerHTML = '<i class="bx bx-menu"></i>';
        }
        toggle.addEventListener('click', function(){
            if(sidebar && sidebar.classList.contains('mobile-open')) closeSidebar();
            else openSidebar();
        });
        backdrop.addEventListener('click', closeSidebar);
    })();
    </script>
</body>
</html>
