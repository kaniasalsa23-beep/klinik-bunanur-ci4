<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Member Pasien - Bunanur Medical Center</title>

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
            margin: 0;
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

        .main-content {
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

        .pasien-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        @media(max-width: 992px) {
            .main-content { margin-left: 85px; width: calc(100% - 85px); padding: 24px 20px; padding-top: 24px !important; }
        }

        @media(max-width: 576px) {
            .main-content { margin-left: 0; width: 100%; padding: 20px 14px; padding-top: 20px !important; }
        }

        .header-container {
            margin-top: 0 !important;
            padding-top: 0 !important;
            margin-bottom: 35px;
        }

        .header-container h1 {
            font-size: 28px;
            font-weight: 800;
            margin: 0 !important;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .header-container p {
            margin: 5px 0 20px;
            font-size: 14px;
            color: #64748b;
        }

        .search-wrapper {
            position: relative;
            width: 360px;
        }

        @media(max-width: 600px) {
            .search-wrapper { width: 100%; }
        }

        .search-wrapper input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border-radius: 30px;
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            outline: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: 0.3s;
        }

        .search-wrapper input:focus {
            border-color: #f43f5e;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
        }

        .search-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #f43f5e;
            font-size: 18px;
        }

        /* GRID CARDS */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
            gap: 25px;
        }

        @media(max-width: 500px) {
            .grid-container { grid-template-columns: 1fr; }
        }

        .id-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 24px;
            padding: 25px;
            display: flex;
            gap: 22px;
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            box-shadow: 0 15px 35px -5px rgba(244, 63, 94, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .id-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -5px rgba(244, 63, 94, 0.18);
            border-color: rgba(244, 63, 94, 0.3);
        }

        .photo-side {
            z-index: 1;
        }

        .photo-side img {
            width: 105px;
            height: 135px;
            object-fit: cover;
            border-radius: 16px;
            border: 3px solid #fff;
            box-shadow: 0 6px 16px rgba(244, 63, 94, 0.15);
        }

        .data-side {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 1;
        }

        .id-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .id-label {
            font-size: 10px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            padding: 4px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-group {
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(244, 63, 94, 0.08);
            padding-bottom: 4px;
        }

        .field-group label {
            display: block;
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .field-group p {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .field-group.name p {
            font-size: 17px;
            color: #1e293b;
            font-weight: 800;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>
<body>

    <!-- 3D Canvas Background -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

    <?= view('includes/sidebar_bidan') ?>

    <div class="main-content">
        <div class="pasien-container">
        <div class="header-container">
            <h1>Data Member Pasien</h1>
            <p>Direktori profil rekam medis pasien terdaftar di Klinik Bunanur</p>
            
            <div class="search-wrapper">
                <i class='bx bx-search'></i>
                <input type="text" id="memberSearch" placeholder="Cari nama member pasien...">
            </div>
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

        <div class="grid-container" id="cardContainer">
            <?php if(!empty($pasien)): ?>
            <?php foreach($pasien as $p): ?>
                <div class="id-card" data-tilt data-tilt-max="4" data-tilt-glare="true" data-tilt-max-glare="0.1">
                    <div class="photo-side">
                        <?php
                        $foto = 'default-hero.png';
                        if (!empty($p['foto']) && file_exists(FCPATH . 'assets/profile/' . $p['foto'])) {
                            $foto = $p['foto'];
                        }
                        ?>
                        <img src="<?= base_url('assets/profile/' . $foto) ?>" alt="Pas Foto">
                    </div>

                    <div class="data-side">
                        <div class="id-header">
                            <span class="id-label"><i class='bx bx-check-circle'></i> Member Aktif</span>
                            <a href="<?= site_url('hapus_pasien/' . (int)$p['id']) ?>"
                               class="btn-delete"
                               title="Hapus Member"
                               onclick="return confirm('Hapus data member ini beserta seluruh rekaman kunjungannya?')">
                                <i class='bx bx-trash'></i>
                            </a>
                        </div>

                        <div class="field-group name">
                            <label>Nama Pasien</label>
                            <p class="name-text"><?= esc($p['nama']) ?></p>
                        </div>

                        <div class="field-group">
                            <label>Alamat Domisili</label>
                            <p><?= !empty($p['alamat']) ? esc($p['alamat']) : 'Jl. Pramuka, Kuningan' ?></p>
                        </div>

                        <div class="field-group" style="border-bottom:none;">
                            <label>Kontak Email / No. HP</label>
                            <p><?= !empty($p['email']) ? esc($p['email']) : (!empty($p['no_hp']) ? esc($p['no_hp']) : '-') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align:center; padding:50px; color:#94a3b8;">
                    Belum ada data pasien terdaftar.
                </div>
            <?php endif; ?>
        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
    <script>
        document.getElementById('memberSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let cards = document.querySelectorAll('.id-card');
            
            cards.forEach(card => {
                let name = card.querySelector('.name-text').innerText.toLowerCase();
                card.style.display = name.includes(filter) ? "flex" : "none";
            });
        });
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
