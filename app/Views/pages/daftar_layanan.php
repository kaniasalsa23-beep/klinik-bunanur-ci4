<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Eksklusif | Klinik Bunanur</title>
    
    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
    
    <style>
        .container { 
            max-width: 1240px; 
            margin: 0 auto; 
            padding: 40px 24px 80px; 
            position: relative;
            z-index: 5;
        }

        .header-title { 
            text-align: center; 
            margin-bottom: 45px; 
        }
        
        .header-title h1 { 
            font-family: var(--font-heading); 
            font-size: 42px; 
            font-weight: 800;
            color: var(--text-heading); 
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .header-title p { 
            font-size: 16px; 
            color: var(--text-muted); 
            margin-top: 6px; 
        }

        /* Card Layanan 3D Glassmorphic */
        .card-layanan {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            overflow: hidden;
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            box-shadow: 0 16px 40px rgba(244, 63, 94, 0.08);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex; 
            flex-direction: column;
            text-decoration: none; 
            color: inherit;
            position: relative;
            transform-style: preserve-3d;
        }

        .card-layanan:hover {
            transform: translateY(-8px);
            border-color: rgba(244, 63, 94, 0.35);
            box-shadow: 0 22px 50px rgba(244, 63, 94, 0.16);
        }

        /* Foto Tidak Gepeng, Proporsi Mewah */
        .card-img-wrapper {
            width: 100%;
            height: 260px; /* Sesuai instruksi 240px - 280px */
            background: #fff1f2;
            overflow: hidden;
            border-top-left-radius: 26px;
            border-top-right-radius: 26px;
            position: relative;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Mencegah gambar terdistorsi/gepeng */
            transition: transform 0.5s ease;
            display: block;
        }

        .card-layanan:hover .card-img { 
            transform: scale(1.06); 
        }

        .card-content { 
            padding: 28px; 
            flex-grow: 1; 
            display: flex; 
            flex-direction: column; 
        }
        
        .card-content h3 { 
            margin: 0 0 10px 0; 
            color: var(--text-heading); 
            font-size: 21px; 
            font-family: var(--font-heading);
            font-weight: 800; 
        }

        .card-deskripsi {
            font-size: 14px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 22px;
            flex-grow: 1;
        }

        .price-tag { 
            color: var(--primary-rose); 
            font-weight: 800; 
            font-size: 20px; 
            margin-top: auto; 
            padding-top: 16px;
            border-top: 1.5px dashed rgba(244, 63, 94, 0.2);
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }

        .card-layanan.hidden { display: none !important; }

        @media (max-width: 768px) {
            .header-title h1 { font-size: 32px; }
            .layanan-grid { grid-template-columns: 1fr; }
            .card-img-wrapper { height: 230px; }
        }
    </style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>

<body>
    <!-- Interactive 3D Background Canvas -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <div class="container">
        <a href="<?= base_url('/') ?>" class="btn-back" style="margin-bottom: 30px;">
            <i class='bx bx-arrow-back'></i> Kembali ke Beranda
        </a>

        <div class="header-title">
            <div class="badge-cyber badge-rose" style="margin-bottom: 14px;">
                ✨ PREMIER CLINICAL SERVICES
            </div>
            <h1>Layanan Eksklusif Ibu & Anak</h1>
            <p>Pilihan perawatan kebidanan profesional dan bersahabat untuk masa depan Bunda dan Buah Hati</p>
        </div>

        <!-- Filter Kategori dengan Glowing Active Pill -->
        <div class="filter-container">
            <button class="filter-btn active" onclick="filterLayanan('all', this)">
                <i class='bx bx-grid-alt'></i> Semua Layanan
            </button>
            <button class="filter-btn" onclick="filterLayanan('ibu', this)">
                <i class='bx bx-female'></i> Perawatan Ibu
            </button>
            <button class="filter-btn" onclick="filterLayanan('bayi', this)">
                <i class='bx bx-child'></i> Perawatan Bayi
            </button>
        </div>

        <!-- Search Bar Glassmorphic -->
        <div class="search-container">
            <div class="search-box">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama layanan atau deskripsi..."
                    onkeyup="searchLayanan()"
                    autocomplete="off">
                <i class='bx bx-search'></i>
            </div>
        </div>

        <!-- Grid Layanan 3D Glassmorphic -->
        <div class="layanan-grid">
            <?php if (!empty($layanan)): ?>
                <?php foreach ($layanan as $row): ?>
                    <div class="card-layanan glass-card-3d"
                         data-tilt data-tilt-max="7" data-tilt-glare data-tilt-max-glare="0.10"
                         data-category="<?= esc(strtolower($row['kategori']), 'attr'); ?>"
                         data-search="<?= esc(strtolower(
                            $row['nama_layanan'] . ' ' .
                            $row['deskripsi'] . ' ' .
                            $row['kategori']
                         ), 'attr'); ?>">

                        <div class="card-img-wrapper">
                            <?php
                            $src_gambar = !empty($row['gambar'])
                                ? base_url('assets/layanan/' . $row['gambar'])
                                : base_url('assets/layanan/default.jpg');
                            ?>
                            <img src="<?= esc($src_gambar, 'attr'); ?>"
                                 class="card-img"
                                 alt="<?= esc($row['nama_layanan']); ?>"
                                 onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
                        </div>

                        <div class="card-content">
                            <span class="badge-kategori <?= strtolower($row['kategori']) == 'ibu' ? 'badge-ibu' : 'badge-bayi' ?>" style="margin-bottom: 12px; align-self: flex-start;">
                                <?= esc($row['kategori']); ?>
                            </span>

                            <h3>
                                <?= esc($row['nama_layanan']); ?>
                            </h3>

                            <div class="card-deskripsi">
                                <?= nl2br(esc($row['deskripsi'])); ?>
                            </div>

                            <div class="price-tag">
                                <span style="font-size: 13.5px; color: var(--text-muted); font-weight: 600;">Biaya Layanan</span>
                                <span>
                                    Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                </span>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center; grid-column: 1 / -1; padding: 60px 20px; background: rgba(255,255,255,0.8); border-radius: 24px; border: 1.5px solid rgba(244,63,94,0.15);">
                    <i class='bx bx-info-circle' style="font-size: 48px; color: var(--primary-rose); margin-bottom: 12px;"></i>
                    <h3 style="font-family: var(--font-heading); color: var(--text-heading); font-size: 22px;">Belum Ada Layanan Tersedia</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Silakan periksa kembali beberapa saat lagi.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
    let currentCategory = 'all';

    function filterLayanan(kategori, btn) {
        currentCategory = kategori;

        document.querySelectorAll('.filter-btn')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        applyFilters();
    }

    function searchLayanan() {
        applyFilters();
    }

    function applyFilters() {
        const keyword = document
            .getElementById('searchInput')
            .value
            .toLowerCase();

        const cards = document.querySelectorAll('.card-layanan');

        cards.forEach(card => {
            const kategori = card.getAttribute('data-category') || '';
            const searchData = card.getAttribute('data-search') || '';

            const cocokKategori =
                currentCategory === 'all' ||
                kategori.includes(currentCategory);

            const cocokSearch =
                searchData.includes(keyword);

            if (cocokKategori && cocokSearch) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
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
