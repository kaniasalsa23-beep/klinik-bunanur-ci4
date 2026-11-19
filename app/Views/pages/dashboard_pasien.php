<?php

$db = \Config\Database::connect();
$session = session();

if (!$session->has('pasien')) {
    header('Location: ' . base_url('/'));
    exit;
}

$pasien = $session->get('pasien');
$id = $pasien['id'];
$id_pasien = $pasien['id'];

// Update last_seen dan status pasien menggunakan waktu PHP Asia/Jakarta
$now = date('Y-m-d H:i:s');
$dashUpdate = ['last_seen' => $now];
if ($db->fieldExists('status', 'pasien')) {
    $dashUpdate['status'] = 'online';
}
$db->table('pasien')->where('id', $id_pasien)->update($dashUpdate);

// Ambil riwayat kunjungan
$riwayat = $db->query(
    "SELECT kunjungan.*, layanan.nama_layanan
     FROM kunjungan
     INNER JOIN layanan ON kunjungan.layanan = layanan.id
     WHERE kunjungan.pasien_id = ?
     ORDER BY kunjungan.tanggal DESC",
    [$id]
);

$riwayatData = $riwayat->getResultArray();
$total_kunjungan = count($riwayatData);

// Foto profil
$foto = !empty($pasien['foto'])
    ? $pasien['foto']
    : 'default.png';

// Ambil status bidan jaga secara dinamis
$isBidanOnline = isset($isBidanOnline) ? $isBidanOnline : ($db->table('bidan')->where('status', 'online')->countAllResults() > 0);
if (!isset($bidan) || empty($bidan)) {
    $bidan = $db->table('bidan')->where('status', 'online')->get()->getRowArray() ?: $db->table('bidan')->orderBy('id', 'ASC')->get()->getRowArray();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien | Klinik Bunanur</title>

    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Master Medical Glassmorphism 3D CSS (Light Mode) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">

    <style>
        :root {
            --primary-rose: #f43f5e;
            --primary-pink: #ec4899;
            --rose-dark: #be123c;
            --card-glass: rgba(255, 255, 255, 0.84);
            --border-glass: rgba(244, 63, 94, 0.16);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* CONTENT ADAPTATION */
        .main-dashboard {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 24px 36px 36px;
            padding-top: 24px !important;
            margin-top: 0 !important;
            min-height: 100vh;
            box-sizing: border-box;
            transition: 0.3s;
            position: relative;
            z-index: 5;
        }

        .dashboard-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* TOPBAR */
        .topbar-cyber {
            margin-top: 0 !important;
            padding-top: 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.12);
        }

        .topbar-cyber h2 {
            font-family: var(--font-heading);
            font-size: 30px;
            color: #4c0519;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-top: 0 !important;
        }

        .topbar-cyber h2 span {
            color: var(--primary-rose);
        }

        .status-bidan-card {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            border: 1.5px solid rgba(244, 63, 94, 0.18);
            box-shadow: 0 4px 14px rgba(244, 63, 94, 0.06);
            font-size: 13px;
            font-weight: 600;
        }

        .status-bidan-online {
            color: #047857;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-bidan-online::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.8);
            animation: blinkPulse 1.6s infinite;
        }

        .status-bidan-offline {
            color: #94a3b8;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-bidan-offline::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #94a3b8;
        }

        @keyframes blinkPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        /* WELCOME BANNER */
        .welcome-box-3d {
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

        .welcome-box-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent);
        }

        .welcome-box-3d h3 {
            font-family: var(--font-heading);
            font-size: 28px;
            font-weight: 800;
            color: #4c0519;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .welcome-box-3d p {
            line-height: 1.75;
            color: #475569;
            font-size: 14.5px;
            max-width: 650px;
        }

        /* ACTION & STAT GRID */
        .grid-cyber {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 35px;
        }

        .card-cyber-3d {
            background: var(--card-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 30px 26px;
            border-radius: 26px;
            border: 1.5px solid var(--border-glass);
            box-shadow: 0 14px 35px rgba(244, 63, 94, 0.08);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            display: flex;
            flex-direction: column;
        }

        .card-cyber-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent);
        }

        .card-cyber-3d:hover {
            border-color: rgba(244, 63, 94, 0.35);
            box-shadow: 0 20px 45px rgba(244, 63, 94, 0.16);
            transform: translateY(-5px);
        }

        .card-icon-cyber {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .icon-box-rose {
            background: #fff1f2;
            color: #f43f5e;
            border: 1.5px solid rgba(244, 63, 94, 0.25);
        }

        .icon-box-pink {
            background: #fdf2f8;
            color: #ec4899;
            border: 1.5px solid rgba(236, 72, 153, 0.25);
        }

        .icon-box-gold {
            background: #fffbeb;
            color: #f59e0b;
            border: 1.5px solid rgba(245, 158, 11, 0.25);
        }

        .card-cyber-3d h3 {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #4c0519;
        }

        .card-cyber-3d p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 22px;
            flex-grow: 1;
        }

        /* TABLE SECTION */
        .table-panel-cyber {
            background: var(--card-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 32px;
            border-radius: 28px;
            border: 1.5px solid var(--border-glass);
            box-shadow: 0 16px 45px rgba(244, 63, 94, 0.08);
        }

        .table-panel-cyber h3 {
            font-family: var(--font-heading);
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 22px;
            color: #4c0519;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-wrapper-cyber {
            border-radius: 20px;
            overflow: hidden;
            border: 1.5px solid rgba(244, 63, 94, 0.14);
            background: #ffffff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fff1f2;
            color: #881337;
            padding: 16px 20px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.15);
        }

        td {
            padding: 16px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(244, 63, 94, 0.08);
            font-size: 14.5px;
            color: #334155;
            transition: all 0.2s ease;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #fff7f9;
            color: #0f172a;
        }

        .badge-status-pasien {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* RESPONSIVE */
        @media(max-width: 992px) {
            .main-dashboard {
                margin-left: 85px;
                padding: 25px;
            }
            .grid-cyber {
                grid-template-columns: 1fr;
            }
            .topbar-cyber {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Interactive 3D Background Canvas (Pink-Rose Floating Particles) -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <!-- SIDEBAR GLOBAL -->
    <?= view('includes/sidebar') ?>

    <!-- MAIN CONTENT -->
    <div class="main-dashboard">
        <div class="dashboard-container">

        <div class="topbar-cyber">
            <h2>
                Halo, <span><?= esc($pasien['nama'] ?? 'Bunda'); ?></span> 🌸
            </h2>
            <div class="status-bidan-card">
                <span>Status Bidan Jaga:</span>
                <?php if (!empty($isBidanOnline)): ?>
                    <span class="status-bidan-online">● Online Siaga</span>
                <?php else: ?>
                    <span class="status-bidan-offline">● Offline / Tidak Aktif</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="welcome-box-3d">
            <div class="badge-cyber badge-rose" style="margin-bottom: 14px;">
                <i class='bx bx-check-shield'></i> Mother & Child Care Platform
            </div>
            <h3>Selamat Datang di Portal Pasien Klinik Bunanur</h3>
            <p>
                Kelola jadwal konsultasi, pantau riwayat rekam medis kunjungan, dan akses informasi layanan perawatan ibu dan buah hati secara transparan, ramah, dan aman.
            </p>
        </div>

        <div class="grid-cyber">
            <!-- Card 1: Konsultasi -->
            <div class="card-cyber-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="card-icon-cyber icon-box-rose">
                    <i class='bx bx-chat'></i>
                </div>
                <h3>Konsultasi Medis</h3>
                <p>
                    Tanya jawab langsung dengan bidan jaga secara privat dan cepat (maksimal 5 pesan gratis).
                </p>
                <button onclick="location.href='<?= base_url('konsultasi') ?>'" class="btn-cyber-primary" style="width: 100%;">
                    <i class='bx bx-paper-plane'></i> Mulai Konsultasi
                </button>
            </div>

            <!-- Card 2: Layanan -->
            <div class="card-cyber-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="card-icon-cyber icon-box-pink">
                    <i class='bx bx-plus-medical'></i>
                </div>
                <h3>Layanan Klinik</h3>
                <p>
                    Eksplorasi paket perawatan kehamilan, imunisasi, spa bayi, dan pemeriksaan pasca-persalinan.
                </p>
                <button onclick="location.href='<?= base_url('layanan') ?>'" class="btn-cyber-secondary" style="width: 100%;">
                    <i class='bx bx-search-alt-2'></i> Lihat Layanan Medis
                </button>
            </div>

            <!-- Card 3: Total Kunjungan -->
            <div class="card-cyber-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="card-icon-cyber icon-box-gold">
                    <i class='bx bx-bar-chart-alt'></i>
                </div>
                <h3>Total Kunjungan</h3>
                <p>
                    Anda telah melakukan <strong style="color: var(--primary-rose);"><?= esc((string)$total_kunjungan) ?> kali</strong> kunjungan medis ke klinik kami.
                </p>
                <button onclick="location.href='<?= base_url('riwayat') ?>'" class="btn-cyber-secondary" style="width: 100%;">
                    <i class='bx bx-time'></i> Detail Riwayat
                </button>
            </div>
        </div>

        <!-- Tabel Riwayat Kunjungan Pasien -->
        <div class="table-panel-cyber">
            <h3>
                <i class='bx bx-history' style="color: var(--primary-rose);"></i> Riwayat Kunjungan Pasien
            </h3>
            
            <div class="table-wrapper-cyber">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <th>Jenis Layanan</th>
                            <th style="text-align: center;">Status Layanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($total_kunjungan > 0): ?>
                            <?php foreach($riwayatData as $r): ?>
                            <tr>
                                <td>
                                    <span style="color: #64748b; font-weight: 600;">
                                        <?= date('d M Y', strtotime($r['tanggal'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong style="color: var(--primary-rose);"><?= esc($r['nama_layanan'] ?? '-'); ?></strong>
                                </td>
                                <td>
                                    <span class="badge-status-pasien">
                                        <span style="font-size: 8px;">●</span> <?= esc(ucfirst($r['status'] ?? 'Selesai')); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="padding: 24px; color: #64748b;">
                                    Belum ada rekam catatan kunjungan terdaftar.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
</body>
</html>
