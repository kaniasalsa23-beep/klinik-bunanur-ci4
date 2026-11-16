<?php

$pasien = $pasien ?? [];
$layanan = $layanan ?? [];

$foto = $pasien['foto'] ?? 'default.png';

$aktif = $aktif ?? '';
$search = $search ?? '';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Layanan Klinik | Portal Pasien Bunanur</title>

    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">

    <style>
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

        .layanan-pasien-container {
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

        .hero-banner-layanan {
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

        .hero-banner-layanan::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent);
        }

        .hero-banner-layanan h2 {
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .hero-banner-layanan p {
            line-height: 1.75;
            color: #475569;
            font-size: 14.5px;
            max-width: 680px;
            margin: 0;
        }

        /* Top Control Bar */
        .top-control-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 35px;
            flex-wrap: wrap;
        }

        .filter-pill-group {
            display: flex;
            background: rgba(255, 255, 255, 0.9);
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            border-radius: 50px;
            padding: 6px;
            box-shadow: 0 8px 24px rgba(244, 63, 94, 0.06);
            gap: 6px;
        }

        .filter-pill-group a {
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            color: var(--rose-dark);
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-pill-group a.active {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(244, 63, 94, 0.35);
        }

        .search-box-pasien {
            display: flex;
            background: rgba(255, 255, 255, 0.9);
            border: 1.5px solid rgba(244, 63, 94, 0.2);
            border-radius: 50px;
            padding: 6px 8px 6px 20px;
            box-shadow: 0 8px 24px rgba(244, 63, 94, 0.06);
            width: 320px;
            align-items: center;
        }

        .search-box-pasien input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            background: transparent;
            color: var(--text-main);
            font-family: inherit;
        }

        .search-box-pasien button {
            border: none;
            background: linear-gradient(135deg, #f43f5e, #ec4899);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3);
        }

        .search-box-pasien button:hover {
            transform: scale(1.06);
        }

        /* Grid Layanan */
        .grid-layanan-pasien {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
            gap: 28px;
            margin-bottom: 40px;
        }

        .card-layanan-pasien {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            border-radius: 28px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 14px 35px rgba(244, 63, 94, 0.08);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            transform-style: preserve-3d;
        }

        .card-layanan-pasien:hover {
            transform: translateY(-8px);
            border-color: rgba(244, 63, 94, 0.35);
            box-shadow: 0 20px 48px rgba(244, 63, 94, 0.16);
        }

        .card-img-wrapper-pasien {
            width: 100%;
            height: 260px; /* Foto tidak gepeng / terpotong aneh */
            background: #fff1f2;
            overflow: hidden;
            border-top-left-radius: 26px;
            border-top-right-radius: 26px;
        }

        .card-img-wrapper-pasien img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }

        .card-layanan-pasien:hover .card-img-wrapper-pasien img {
            transform: scale(1.06);
        }

        .card-body-pasien {
            padding: 26px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-body-pasien h3 {
            font-family: var(--font-heading);
            font-size: 21px;
            color: var(--text-heading);
            margin: 0 0 10px 0;
            font-weight: 800;
        }

        .deskripsi-pasien-text {
            font-size: 14px;
            color: #64748b;
            line-height: 1.65;
            margin-bottom: 20px;
            height: 65px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .meta-pasien {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 16px;
            border-top: 1.5px dashed rgba(244, 63, 94, 0.2);
            font-weight: 700;
            color: var(--primary-rose);
            font-size: 15px;
        }

        .btn-lihat-detail {
            margin-top: 18px;
            width: 100%;
            padding: 12px;
            background: #fff1f2;
            color: var(--rose-dark);
            border: 1.5px solid rgba(244, 63, 94, 0.25);
            border-radius: 16px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-lihat-detail:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 6px 18px rgba(244, 63, 94, 0.3);
        }

        /* Modal Detail Glassmorphic */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            border-radius: 30px;
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .detail-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.15);
        }

        .detail-body {
            padding: 30px;
        }

        .detail-body h2 {
            font-family: var(--font-heading);
            font-size: 24px;
            font-weight: 800;
            color: #4c0519;
            margin: 12px 0 10px;
        }

        .detail-body p {
            color: #475569;
            font-size: 14.5px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .btn-close-flat {
            width: 100%;
            background: none;
            border: none;
            padding: 12px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 14px;
            font-family: inherit;
            color: #64748b;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .btn-close-flat:hover {
            color: var(--primary-rose);
        }
    </style>
</head>
<body>

    <!-- Interactive 3D Background Canvas -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <?= view('includes/sidebar'); ?>

    <div class="main">
        <div class="layanan-pasien-container">

        <!-- Topbar -->
        <div class="topbar">
            <div>
                <h1>Layanan Klinik Bunanur</h1>
                <p>Eksplorasi layanan terbaik sesuai kebutuhan Bunda dan Buah Hati</p>
            </div>
        </div>

        <!-- Hero Card Banner -->
        <div class="hero-banner-layanan">
            <div class="badge-cyber badge-rose" style="margin-bottom: 12px;">
                🌸 Gentle Care Mother & Baby
            </div>
            <h2>Layanan Medis Ibu & Anak</h2>
            <p>
                Setiap layanan dapat diajukan sebagai janji kunjungan klinik sesuai rekomendasi jadwal yang tepat dan nyaman dari bidan.
            </p>
        </div>

        <!-- Filter + Search Bar -->
        <div class="top-control-bar">
            <div class="filter-pill-group">
                <a href="<?= base_url('layanan') . (!empty($search) ? '?search=' . urlencode($search) : '') ?>" class="<?= $aktif==''?'active':'' ?>">Semua</a>
                <a href="<?= base_url('layanan') . '?kategori=ibu' . (!empty($search) ? '&search=' . urlencode($search) : '') ?>" class="<?= $aktif=='ibu'?'active':'' ?>">Ibu</a>
                <a href="<?= base_url('layanan') . '?kategori=bayi' . (!empty($search) ? '&search=' . urlencode($search) : '') ?>" class="<?= $aktif=='bayi'?'active':'' ?>">Bayi</a>
            </div>

            <form method="GET" action="<?= base_url('layanan') ?>" class="search-box-pasien">
                <?php if (!empty($aktif)): ?>
                    <input type="hidden" name="kategori" value="<?= esc($aktif, 'attr'); ?>">
                <?php endif; ?>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari layanan..."
                    value="<?= esc($search, 'attr'); ?>"
                >
                <button type="submit" title="Cari">
                    <i class='bx bx-search'></i>
                </button>
            </form>
        </div>

        <!-- Grid Layanan -->
        <div class="grid-layanan-pasien">
            <?php if(empty($layanan)): ?>
                <div style="grid-column: 1 / -1; text-align:center; padding:60px 20px; background: rgba(255,255,255,0.8); border-radius: 24px; border: 1.5px solid rgba(244,63,94,0.15);">
                    <i class='bx bx-search-alt' style="font-size: 48px; color: var(--primary-rose); margin-bottom: 12px;"></i>
                    <h3 style="font-family: var(--font-heading); color: var(--text-heading); font-size: 20px;">Tidak Ada Layanan Ditemukan</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Silakan coba kata kunci pencarian atau kategori lain.</p>
                </div>
            <?php endif; ?>

            <?php foreach($layanan as $l): ?>
            <?php
            $r = $l['avg_rating'] ?? 0;
            $total = $l['total_rating'] ?? 0;
            ?>

            <div class="card-layanan-pasien glass-card-3d" data-tilt data-tilt-max="7" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="card-img-wrapper-pasien">
                    <img src="<?= base_url('assets/layanan/' . (!empty($l['gambar']) ? $l['gambar'] : 'default.png')) ?>"
                         alt="<?= htmlspecialchars($l['nama_layanan']); ?>"
                         onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
                </div>

                <div class="card-body-pasien">
                    <span class="badge-kategori <?= strtolower($l['kategori']) == 'ibu' ? 'badge-ibu' : 'badge-bayi' ?>" style="margin-bottom: 12px; align-self: flex-start;">
                        <?= htmlspecialchars($l['kategori']); ?>
                    </span>

                    <h3><?= htmlspecialchars($l['nama_layanan']); ?></h3>

                    <p class="deskripsi-pasien-text">
                        <?= htmlspecialchars($l['deskripsi']); ?>
                    </p>

                    <div class="meta-pasien">
                        <span>Rp <?= number_format($l['harga'], 0, ',', '.'); ?></span>
                        <span style="font-size: 13px; color: var(--text-muted); font-weight: 600;">
                            <i class='bx bx-time'></i> <?= $l['durasi']; ?>
                        </span>
                    </div>

                    <button 
                        type="button"
                        class="btn-lihat-detail"
                        onclick='openModal(
                            <?= json_encode($l["gambar"]); ?>,
                            <?= json_encode($l["kategori"]); ?>,
                            <?= json_encode($l["nama_layanan"]); ?>,
                            <?= json_encode($l["deskripsi"]); ?>,
                            <?= json_encode(number_format($l["harga"], 0, ",", ".")); ?>,
                            <?= json_encode($l["durasi"]); ?>,
                            <?= $l["id"]; ?>,
                            <?= $r ?: 0 ?>,
                            <?= $total ?: 0 ?>
                        )'>
                        <i class='bx bx-info-circle'></i> Lihat Detail & Ajukan
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal Detail -->
        <div id="modalDetail" class="modal">
            <div class="modal-content glass-card-3d">
                <img id="md_gambar" class="detail-img" alt="Detail Layanan">

                <div class="detail-body">
                    <span class="badge-kategori badge-rose" id="md_kategori"></span>
                    <h2 id="md_nama"></h2>
                    <p id="md_deskripsi"></p>

                    <div class="meta-pasien" style="margin-bottom: 22px;">
                        <span id="md_harga" style="font-size: 20px;"></span>
                        <span id="md_durasi" style="color: var(--text-muted); font-size: 14px;"></span>
                    </div>

                    <button id="md_btn" class="btn-cyber-primary" style="width: 100%; padding: 14px; font-size: 15px;">
                        <i class='bx bx-calendar-plus'></i> Ajukan Jadwal Kunjungan
                    </button>

                    <button onclick="closeModal()" class="btn-close-flat">
                        Tutup Modal
                    </button>
                </div>
            </div>
        </div>

        </div> <!-- Penutup .layanan-pasien-container -->
    </div> <!-- Penutup .main -->

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
    function openModal(gambar,kategori,nama,deskripsi,harga,durasi,id,rating,total){
        document.getElementById("modalDetail").style.display="flex";
        document.getElementById("md_gambar").src = "<?= base_url('assets/layanan/') ?>/" + (gambar ? gambar : "default.png");
        document.getElementById("md_kategori").innerText = kategori;
        document.getElementById("md_nama").innerText = nama;
        document.getElementById("md_deskripsi").innerText = deskripsi;
        document.getElementById("md_harga").innerText = "Rp " + harga;
        document.getElementById("md_durasi").innerText = "Durasi: " + durasi;

        document.getElementById("md_btn").onclick = function(){
            window.location.href = "<?= base_url('ajukan_kunjungan') ?>/" + id;
        };
    }

    function closeModal() {
        const modal = document.getElementById("modalDetail");
        if (modal) {
            modal.style.display = "none";
        }
    }

    window.onclick = function(event) {
        const modal = document.getElementById("modalDetail");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
</html>
