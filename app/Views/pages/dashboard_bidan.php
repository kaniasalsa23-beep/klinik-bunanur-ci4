<?php

$bidan = $bidan ?? [];

$foto = !empty($bidan['foto'])
    ? base_url('assets/profile/' . $bidan['foto'])
    : base_url('assets/profile/default.png');

$online = session()->has('bidan');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Kendali Medis | Bunanur Clinic</title>
    
    <!-- Fonts & Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            display: flex; 
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Layout Adjustment */
        .main-content { 
            margin-left: 260px; 
            width: calc(100% - 260px); 
            padding: 24px 36px 36px; 
            padding-top: 24px !important;
            margin-top: 0 !important;
            box-sizing: border-box;
            transition: all 0.3s ease;
            position: relative;
            z-index: 5;
        }

        .dashboard-inner-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Header Section */
        .header-box { 
            margin-top: 0 !important;
            padding-top: 0 !important;
            margin-bottom: 35px; 
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding-bottom: 20px;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.12);
        }

        .header-box h1 { 
            font-family: var(--font-heading);
            font-size: 32px; 
            font-weight: 800; 
            color: #4c0519;
            letter-spacing: -0.5px;
            margin-top: 0 !important;
        }

        .header-box p { 
            color: #64748b; 
            font-size: 15px; 
            margin-top: 6px; 
        }

        .security-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 20px;
            background: #ecfdf5;
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: #047857;
            font-size: 12.5px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.12);
        }

        /* Stats Grid */
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 22px; 
            margin-bottom: 35px; 
        }

        .stat-card-3d { 
            background: var(--card-glass); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 26px 24px; 
            border-radius: 24px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: 0 14px 35px rgba(244, 63, 94, 0.08);
            border: 1.5px solid var(--border-glass);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .stat-card-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.95), transparent);
        }

        .stat-card-3d:hover { 
            border-color: rgba(244, 63, 94, 0.35);
            box-shadow: 0 18px 45px rgba(244, 63, 94, 0.16);
            transform: translateY(-5px);
        }

        .stat-info p { 
            font-size: 11.5px; 
            font-weight: 800; 
            color: #881337; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            margin-bottom: 6px;
        }

        .stat-info h3 { 
            font-family: var(--font-heading);
            font-size: 34px; 
            font-weight: 800; 
            color: #4c0519; 
            line-height: 1;
        }

        .stat-icon-wrapper { 
            width: 58px;
            height: 58px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
        }

        .icon-rose {
            background: #fff1f2;
            color: #f43f5e;
            border: 1.5px solid rgba(244, 63, 94, 0.25);
        }

        .icon-pink {
            background: #fdf2f8;
            color: #ec4899;
            border: 1.5px solid rgba(236, 72, 153, 0.25);
        }

        .icon-amber {
            background: #fffbeb;
            color: #f59e0b;
            border: 1.5px solid rgba(245, 158, 11, 0.25);
        }

        .icon-emerald {
            background: #ecfdf5;
            color: #10b981;
            border: 1.5px solid rgba(16, 185, 129, 0.25);
        }

        /* Glass Content Panels */
        .glass-panel-section { 
            background: var(--card-glass); 
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 32px; 
            border-radius: 28px; 
            box-shadow: 0 16px 45px rgba(244, 63, 94, 0.08); 
            border: 1.5px solid var(--border-glass);
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
        }

        .glass-panel-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(244, 63, 94, 0.35), transparent);
        }

        .card-title-bar { 
            font-family: var(--font-heading);
            font-size: 21px; 
            font-weight: 800; 
            color: #4c0519; 
            margin-bottom: 22px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .link-view-all {
            font-family: var(--font-sans);
            font-size: 13.5px;
            font-weight: 700;
            color: var(--primary-rose);
            text-decoration: none;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 12px;
            background: #fff1f2;
            border: 1px solid rgba(244, 63, 94, 0.25);
        }

        .link-view-all:hover {
            color: #ffffff;
            background: var(--primary-rose);
            box-shadow: 0 4px 14px rgba(244, 63, 94, 0.25);
            transform: translateX(3px);
        }

        /* Table Styling */
        .table-responsive-cyber { 
            border-radius: 20px; 
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; 
            width: 100%;
            border: 1.5px solid rgba(244, 63, 94, 0.14);
            background: #ffffff;
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        
        thead { 
            background: #fff1f2; 
            color: #881337; 
        }
        
        th { 
            padding: 16px 20px; 
            text-align: left; 
            font-size: 13px; 
            font-weight: 800; 
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.15);
        }
        
        td { 
            padding: 16px 20px; 
            font-size: 14.5px; 
            border-bottom: 1px solid rgba(244, 63, 94, 0.08); 
            color: #334155;
            transition: all 0.2s ease;
        }
        
        tr:last-child td { border-bottom: none; }
        
        tr:hover td { 
            background-color: #fff7f9; 
            color: #0f172a;
        }

        /* Badges */
        .badge-status { 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 12px; 
            font-weight: 700; 
            display: inline-flex; 
            align-items: center;
            gap: 6px;
        }

        .badge-waiting-cyber { 
            background: #fffbeb; 
            color: #b45309; 
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .badge-success-cyber { 
            background: #ecfdf5; 
            color: #047857; 
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .main-content { margin-left: 85px; width: calc(100% - 85px); padding: 25px; }
            .header-box { flex-direction: column; align-items: flex-start; gap: 12px; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <!-- Interactive 3D Background Canvas (Pink-Rose Floating Particles) -->
    <canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>
    <div class="cyber-glow-blob cyber-glow-1"></div>
    <div class="cyber-glow-blob cyber-glow-2"></div>

    <!-- Sidebar Bidan -->
    <?= view('includes/sidebar_bidan', ['bidan' => $bidan]) ?>

    <main class="main-content">
        <div class="dashboard-inner-container">
        <!-- Header -->
        <header class="header-box">
            <div>
                <h1>Pusat Kendali Medis</h1>
                <p>
                    Selamat bertugas, 
                    <strong style="color: #f43f5e;"><?= isset($bidan) && isset($bidan['nama']) ? esc($bidan['nama']) : 'Bdn. Bunanur'; ?></strong>. 
                    Berikut rekapitulasi data klinis dan kunjungan pasien hari ini.
                </p>
            </div>
            <div class="security-badge-top">
                <i class='bx bx-check-shield'></i> Sesi Medis Terverifikasi (CI4)
            </div>
        </header>

        <!-- Stats Grid with 3D Card Tilt -->
        <section class="stats-grid">
            <div class="stat-card-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="stat-info">
                    <p>Total Pasien</p>
                    <h3><?= number_format($jPasien ?? 0) ?></h3>
                </div>
                <div class="stat-icon-wrapper icon-rose">
                    <i class='bx bxs-user-detail'></i>
                </div>
            </div>

            <div class="stat-card-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="stat-info">
                    <p>Konsultasi Chat</p>
                    <h3><?= number_format($jKonsul ?? 0) ?></h3>
                </div>
                <div class="stat-icon-wrapper icon-pink">
                    <i class='bx bxs-chat'></i>
                </div>
            </div>

            <div class="stat-card-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="stat-info">
                    <p>Antrean Menunggu</p>
                    <h3><?= number_format($jKunjungan ?? 0) ?></h3>
                </div>
                <div class="stat-icon-wrapper icon-amber">
                    <i class='bx bxs-time-five'></i>
                </div>
            </div>

            <div class="stat-card-3d" data-tilt data-tilt-max="8" data-tilt-glare data-tilt-max-glare="0.10">
                <div class="stat-info">
                    <p>Ulasan & Testimoni</p>
                    <h3><?= number_format($jTesti ?? 0) ?></h3>
                </div>
                <div class="stat-icon-wrapper icon-emerald">
                    <i class='bx bxs-star'></i>
                </div>
            </div>
        </section>

        <!-- Tabel Antrean Terkini (Light Glass Table) -->
        <section class="glass-panel-section">
            <div class="card-title-bar">
                <span><i class='bx bx-list-check' style="color: var(--primary-rose); margin-right: 8px;"></i> Daftar Antrean Kunjungan Pasien</span>
                <a href="<?= base_url('kunjungan_bidan') ?>" class="link-view-all">
                    Lihat Semua Antrean <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <div class="table-responsive-cyber">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Layanan Medis</th>
                            <th>Tanggal Kunjungan</th>
                            <th style="text-align:center;">Status Layanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kunjungan_terbaru)): ?>
                            <?php foreach($kunjungan_terbaru as $k): ?>
                            <tr>
                                <td>
                                    <strong style="color: #4c0519;"><?= esc($k['nama_pasien'] ?? '-') ?></strong>
                                </td>
                                <td>
                                    <span style="color: var(--primary-rose); font-weight: 600;"><?= esc($k['nama_layanan'] ?? '-') ?></span>
                                </td>
                                <td style="color: #64748b;">
                                    <?= !empty($k['tanggal']) ? date('d M Y', strtotime($k['tanggal'])) : '-' ?>
                                </td>
                                <td align="center">
                                    <?php if (strtolower($k['status'] ?? '') == 'menunggu'): ?>
                                        <span class="badge-status badge-waiting-cyber">
                                            <span style="font-size: 8px;">●</span> Menunggu
                                        </span>
                                    <?php else: ?>
                                        <span class="badge-status badge-success-cyber">
                                            <span style="font-size: 8px;">●</span> Selesai
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b; padding: 24px;">
                                    Belum ada data kunjungan terbaru hari ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Grafik Tren Kunjungan Bulanan (Rose Light Mode Chart.js) -->
        <section class="glass-panel-section">
            <div class="card-title-bar">
                <span>
                    <i class='bx bx-line-chart' style="color: var(--primary-rose); margin-right: 8px;"></i> 
                    Statistik & Tren Kunjungan Pasien Bulanan (<?= date('Y') ?>)
                </span>
                <span class="badge-status badge-rose">
                    Tahun <?= date('Y') ?> Realtime
                </span>
            </div>
            <div style="height: 380px; position: relative;">
                <canvas id="chartKunjungan"></canvas>
            </div>
        </section>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
    <script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('chartKunjungan');
        if (!canvas) {
            console.warn('Elemen canvas #chartKunjungan tidak ditemukan.');
            return;
        }

        const ctx = canvas.getContext('2d');

        // Mengambil data JSON dari Controller CI4
        const dataChart = <?= is_string($dataChart ?? null) ? $dataChart : json_encode(array_values($dataChart ?? array_fill(0, 12, 0))) ?>;

        // Gradient fill bernuansa Rose Pink to Soft White
        const gradient = ctx.createLinearGradient(0, 0, 0, 360);
        gradient.addColorStop(0, 'rgba(244, 63, 94, 0.38)');   // Rose pink di atas
        gradient.addColorStop(0.5, 'rgba(244, 63, 94, 0.12)'); // Soft pink di tengah
        gradient.addColorStop(1, 'rgba(253, 242, 248, 0.00)'); // Pudar di bawah

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr',
                    'Mei', 'Jun', 'Jul', 'Agu',
                    'Sep', 'Okt', 'Nov', 'Des'
                ],
                datasets: [{
                    label: 'Jumlah Kunjungan Pasien',
                    data: dataChart,
                    borderColor: '#f43f5e',
                    backgroundColor: gradient,
                    borderWidth: 3.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#f43f5e',
                    pointBorderWidth: 2.5,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#f43f5e',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3,
                    pointHitRadius: 14
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.96)',
                        borderColor: 'rgba(244, 63, 94, 0.4)',
                        borderWidth: 1.5,
                        titleColor: '#4c0519',
                        bodyColor: '#be123c',
                        titleFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13,
                            weight: '700'
                        },
                        bodyFont: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 13,
                            weight: '600'
                        },
                        padding: 14,
                        cornerRadius: 12,
                        boxPadding: 6,
                        usePointStyle: true,
                        callbacks: {
                            label: function (context) {
                                return ` ${context.parsed.y} Kunjungan Terdata`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(244, 63, 94, 0.08)',
                            drawBorder: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            color: '#64748b',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 12
                            },
                            callback: function (value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
    </script>
</body>
</html>
