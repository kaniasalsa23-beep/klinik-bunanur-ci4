<?php
$today            = $today ?? 0;
$pending          = $pending ?? 0;
$done             = $done ?? 0;
$total_kunjungan  = $total_kunjungan ?? 0;
$search_nama      = $search_nama ?? '';
$filter_tgl       = $filter_tgl ?? '';
$kunjungan        = $kunjungan ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Validasi Kunjungan Pasien - Bunanur Medical Center</title>

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

        .kunjungan-container {
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
            margin-bottom: 30px;
        }

        .topbar h1 {
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
        }

        /* STATS */
        .stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
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
            box-shadow: 0 10px 25px rgba(244, 63, 94, 0.06); 
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(244, 63, 94, 0.12);
        }

        .stat { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        .stat h3 { 
            font-size: 30px; 
            font-weight: 800;
            color: #1e293b; 
            line-height: 1;
        }

        .stat p {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            margin-top: 6px;
        }

        .stat i {
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

        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            min-width: 950px; 
        }

        th { 
            background: linear-gradient(135deg, #f43f5e, #ec4899); 
            color: white; 
            padding: 14px 16px; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        th:first-child { border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
        th:last-child { border-top-right-radius: 14px; border-bottom-right-radius: 14px; text-align: center; }

        td { 
            padding: 16px; 
            font-size: 13px; 
            border-bottom: 1px solid rgba(244, 63, 94, 0.08); 
            vertical-align: middle; 
            color: #334155;
        }

        /* Filter Wrapper */
        .filter-wrapper { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
            flex-wrap: wrap; 
            gap: 15px; 
        }

        .search-group { 
            display: flex; 
            gap: 10px; 
            align-items: center; 
            background: rgba(255, 255, 255, 0.9); 
            padding: 8px 14px; 
            border-radius: 16px; 
            border: 1.5px solid rgba(244, 63, 94, 0.16);
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .input-custom { 
            padding: 8px 12px; 
            border-radius: 10px; 
            border: 1px solid rgba(244, 63, 94, 0.16); 
            font-family: inherit; 
            font-size: 13px; 
            outline: none; 
            color: #1e293b;
        }

        .input-custom:focus {
            border-color: #f43f5e;
        }

        .status { 
            padding: 5px 12px; 
            border-radius: 30px; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase; 
            display: inline-block;
        }

        .wait { background: #fef3c7; color: #b45309; }
        .ok { background: #dcfce7; color: #15803d; }
        .approved { background: #dbeafe; color: #1e40af; }
        .reject { background: #fee2e2; color: #b91c1c; }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box-detail {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            border: 1.5px solid rgba(244, 63, 94, 0.22);
            border-radius: 28px;
            padding: 32px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 25px 60px rgba(244, 63, 94, 0.18);
            position: relative;
        }

        .modal-header-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1.5px solid rgba(244, 63, 94, 0.12);
        }

        .modal-header-detail h3 {
            font-size: 20px;
            font-weight: 800;
            color: #4c0519;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-close-modal {
            background: rgba(244, 63, 94, 0.1);
            color: #f43f5e;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.25s;
        }

        .btn-close-modal:hover {
            background: #f43f5e;
            color: #fff;
        }

        .detail-item {
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding-bottom: 10px;
            border-bottom: 1px dashed rgba(244, 63, 94, 0.12);
        }

        .detail-item span.label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .detail-item span.val {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
            text-align: right;
        }

        .btn { 
            padding: 8px 14px; 
            border-radius: 12px; 
            text-decoration: none; 
            color: white; 
            transition: .3s; 
            font-size: 13px; 
            font-weight: 700;
            border: none; 
            cursor: pointer; 
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn:hover { 
            transform: translateY(-2px); 
            opacity: 0.95; 
        }

        .approve { background: #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); }
        .done { background: linear-gradient(135deg, #f43f5e, #ec4899); box-shadow: 0 4px 12px rgba(244, 63, 94, 0.25); }
        .tolak { background: #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25); }
    </style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar_bidan') ?>

<div class="main">
    <div class="kunjungan-container">
    <div class="topbar">
        <h1>Validasi Kunjungan Pasien</h1>
        <p>Dashboard Verifikasi Medis - Pantau antrean & kelayakan kunjungan pasien</p>
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
            <div class="stat">
                <div><h3><?= esc((string)$today) ?></h3><p>Hari Ini</p></div>
                <i class='bx bx-calendar' style="color: #f43f5e; background: rgba(244, 63, 94, 0.1);"></i>
            </div>
        </div>
        <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
            <div class="stat">
                <div><h3><?= esc((string)$pending) ?></h3><p>Menunggu</p></div>
                <i class='bx bx-time-five' style="color: #f59e0b; background: rgba(245, 158, 11, 0.1);"></i>
            </div>
        </div>
        <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
            <div class="stat">
                <div><h3><?= esc((string)$done) ?></h3><p>Selesai</p></div>
                <i class='bx bx-check-double' style="color: #10b981; background: rgba(16, 185, 129, 0.1);"></i>
            </div>
        </div>
        <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
            <div class="stat">
                <div><h3><?= esc((string)$total_kunjungan) ?></h3><p>Total Filter</p></div>
                <i class='bx bx-list-ul' style="color: #8b5cf6; background: rgba(139, 92, 246, 0.1);"></i>
            </div>
        </div>
    </div>

    <div class="filter-wrapper">
        <?php
        $pdfQuery = [];
        if (!empty($search_nama)) $pdfQuery['q'] = $search_nama;
        if (!empty($filter_tgl)) $pdfQuery['tgl'] = $filter_tgl;
        $pdfUrl = site_url('kunjungan_bidan/pdf') . (!empty($pdfQuery) ? '?' . http_build_query($pdfQuery) : '');
        ?>
        <a href="<?= $pdfUrl ?>" class="btn done" target="_blank">
            <i class='bx bx-printer'></i> Cetak Rekapitulasi PDF
        </a>

        <form action="<?= site_url('kunjungan_bidan') ?>" method="GET" class="search-group">
            <input type="text" name="q" placeholder="Cari nama pasien..." value="<?= esc($search_nama) ?>" class="input-custom" style="width: 200px;">
            <input type="date" name="tgl" value="<?= esc($filter_tgl) ?>" class="input-custom">
            <button type="submit" class="btn done"><i class='bx bx-search'></i> Filter</button>
            <?php if(!empty($filter_tgl) || !empty($search_nama)): ?>
                <a href="<?= site_url('kunjungan_bidan') ?>" style="color: #f43f5e; font-size: 12px; font-weight: 700; text-decoration: none; margin-left: 4px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-box">
        <h3 style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 20px;">Daftar Pengajuan Kunjungan Medis</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pasien</th>
                    <th>Detail Pasien</th>
                    <th>Alamat Domisili</th>
                    <th>Paket Layanan</th>
                    <th>Waktu Kunjungan</th>
                    <th>Status</th>
                    <th>Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($kunjungan)): ?>
                <?php foreach ($kunjungan as $k): ?>
                <?php
                $s = strtolower($k['status'] ?? '');
                if ($s == 'selesai') {
                    $sc = 'ok';
                    $stext = 'Selesai';
                } elseif ($s == 'gagal') {
                    $sc = 'reject';
                    $stext = 'Gagal';
                } elseif ($s == 'disetujui') {
                    $sc = 'approved';
                    $stext = 'Disetujui';
                } else {
                    $sc = 'wait';
                    $stext = 'Menunggu';
                }
                ?>
                <tr>
                    <td style="font-weight:800; color:#94a3b8;">
                        #<?= esc($k['id']) ?>
                    </td>
                    <td style="font-weight:700; color:#1e293b;">
                        <?= esc($k['nama_pasien']) ?>
                    </td>
                    <td style="line-height: 1.5;">
                        <span style="display:block; font-size:12px; color:#64748b;">
                            Usia: <b><?= esc($k['usia']) ?></b>
                        </span>
                        <span style="font-size:12px; color:#f43f5e; font-weight:600;">
                            Wali: <?= esc($k['nama_ortu']) ?>
                        </span>
                    </td>
                    <td style="font-size:12px; color:#64748b; max-width:160px;">
                        <i class='bx bx-map-pin' style="color:#f43f5e;"></i>
                        <?= !empty($k['alamat']) ? esc($k['alamat']) : '<i>Tidak diisi</i>' ?>
                    </td>
                    <td>
                        <span style="background: rgba(244, 63, 94, 0.08); padding: 5px 12px; border-radius: 8px; color: #f43f5e; font-weight: 700; font-size: 12px;">
                            <?= esc($k['nama_layanan']) ?>
                        </span>
                    </td>
                    <td style="font-size:12px;">
                        <b><?= date('d M Y', strtotime($k['tanggal'])) ?></b><br>
                        <span style="color:#f43f5e; font-weight:600;">
                            <i class='bx bx-time'></i> <?= esc($k['jam']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="status <?= esc($sc, 'attr') ?>">
                            <?= esc($stext) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; justify-content:center; gap:6px;">
                            <button type="button" class="btn" style="background:#6366f1; box-shadow:0 4px 12px rgba(99,102,241,0.25);" onclick="openDetailModal(<?= htmlspecialchars(json_encode($k), ENT_QUOTES, 'UTF-8') ?>)" title="Lihat Detail Lengkap">
                                <i class='bx bx-show'></i>
                            </button>
                            <a class="btn approve" title="Setujui Kunjungan" href="<?= site_url('kunjungan_bidan/aksi/approve/' . (int)$k['id']) ?>">
                                <i class='bx bx-check'></i>
                            </a>
                            <a class="btn done" title="Tandai Selesai" href="<?= site_url('kunjungan_bidan/aksi/done/' . (int)$k['id']) ?>">
                                <i class='bx bx-calendar-check'></i>
                            </a>
                            <a class="btn tolak" title="Tolak Pengajuan" href="<?= site_url('kunjungan_bidan/aksi/tolak/' . (int)$k['id']) ?>" onclick="return confirm('Tolak kunjungan ini?')">
                                <i class='bx bx-x'></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="padding:50px; color:#94a3b8; text-align:center;">
                        Data kunjungan tidak ditemukan atau belum ada pengajuan.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<!-- Modal Detail Kunjungan Medis -->
<div id="detailModal" class="modal-overlay" onclick="if(event.target===this) closeDetailModal();">
    <div class="modal-box-detail">
        <div class="modal-header-detail">
            <h3><i class='bx bx-notepad' style="color:#f43f5e;"></i> Detail Kunjungan Medis</h3>
            <button type="button" class="btn-close-modal" onclick="closeDetailModal()">&times;</button>
        </div>
        <div class="modal-body-detail">
            <div class="detail-item">
                <span class="label">ID Kunjungan:</span>
                <span class="val" id="md-id" style="font-weight:800; color:#f43f5e;">#--</span>
            </div>
            <div class="detail-item">
                <span class="label">Nama Pasien:</span>
                <span class="val" id="md-nama" style="font-weight:700;">--</span>
            </div>
            <div class="detail-item">
                <span class="label">Usia:</span>
                <span class="val" id="md-usia">--</span>
            </div>
            <div class="detail-item">
                <span class="label">Pendamping / Wali:</span>
                <span class="val" id="md-wali">--</span>
            </div>
            <div class="detail-item">
                <span class="label">Paket Layanan:</span>
                <span class="val" id="md-layanan" style="color:#f43f5e; font-weight:700;">--</span>
            </div>
            <div class="detail-item">
                <span class="label">Jadwal Tanggal & Jam:</span>
                <span class="val" id="md-jadwal">--</span>
            </div>
            <div class="detail-item">
                <span class="label">Alamat Pasien:</span>
                <span class="val" id="md-alamat">--</span>
            </div>
            <div class="detail-item" style="border-bottom:none;">
                <span class="label">Status Verifikasi:</span>
                <span class="val" id="md-status">--</span>
            </div>
        </div>
        <div style="margin-top:22px; display:flex; gap:10px; justify-content:flex-end;">
            <button type="button" class="btn" style="background:#e2e8f0; color:#475569;" onclick="closeDetailModal()">Tutup</button>
            <a id="md-btn-approve" href="#" class="btn approve"><i class='bx bx-check'></i> Setujui</a>
            <a id="md-btn-done" href="#" class="btn done"><i class='bx bx-calendar-check'></i> Selesai</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
function openDetailModal(data) {
    if (!data) return;
    document.getElementById('md-id').innerText = '#' + (data.id || '-');
    document.getElementById('md-nama').innerText = data.nama_pasien || '-';
    document.getElementById('md-usia').innerText = (data.usia || '-') + ' Tahun';
    document.getElementById('md-wali').innerText = (data.nama_ortu || '-') + (data.kategori_pendamping ? ' (' + data.kategori_pendamping + ')' : '');
    document.getElementById('md-layanan').innerText = data.nama_layanan || '-';
    document.getElementById('md-jadwal').innerText = (data.tanggal || '-') + ' pukul ' + (data.jam || '-');
    document.getElementById('md-alamat').innerText = data.alamat || 'Tidak diisi';
    document.getElementById('md-status').innerText = (data.status || '-').toUpperCase();

    document.getElementById('md-btn-approve').href = "<?= site_url('kunjungan_bidan/aksi/approve/') ?>" + data.id;
    document.getElementById('md-btn-done').href = "<?= site_url('kunjungan_bidan/aksi/done/') ?>" + data.id;

    document.getElementById('detailModal').classList.add('active');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('active');
}
</script>
</body>
</html>
