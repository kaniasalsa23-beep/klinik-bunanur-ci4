<?php
$total   = $total   ?? 0;
$ibu     = $ibu     ?? 0;
$bayi    = $bayi    ?? 0;
$filter  = $filter  ?? '';
$search  = $search  ?? '';
$layanan = $layanan ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kelola Layanan - Bunanur Medical Center</title>

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

.layanan-container {
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
    display: flex;
    justify-content: space-between;
    align-items: center;
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
    color: #f43f5e;
    background: rgba(244, 63, 94, 0.1);
    padding: 12px;
    border-radius: 18px;
}

/* ACTION BAR */
.action-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 25px;
}

.action-left {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: #fff;
    padding: 12px 24px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.28);
    transition: 0.3s;
}

.btn-tambah:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(244, 63, 94, 0.38);
}

/* FILTER PILL */
.filter-box {
    display: flex;
    position: relative;
    padding: 4px;
    border-radius: 40px;
    background: rgba(255, 255, 255, 0.85);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    box-shadow: 0 6px 18px rgba(0,0,0,.04);
    width: 270px;
}

.filter-btn {
    flex: 1;
    text-align: center;
    padding: 8px 0;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
    color: #64748b;
    z-index: 2;
    transition: color 0.3s;
}

.filter-btn.active-filter {
    color: #fff;
}

.slider {
    position: absolute;
    top: 4px;
    left: 4px;
    width: calc((100% - 8px) / 3);
    height: calc(100% - 8px);
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    border-radius: 30px;
    transition: 0.3s ease;
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.35);
}

.slider.left { transform: translateX(0%); }
.slider.middle { transform: translateX(100%); }
.slider.right { transform: translateX(200%); }

/* SEARCH BOX */
.search-box {
    position: relative;
    width: 280px;
}

.search-box input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border-radius: 30px;
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    background: rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    outline: none;
    font-family: inherit;
    font-size: 13px;
    color: #1e293b;
    transition: .3s;
}

.search-box input:focus {
    border-color: #f43f5e;
    background: white;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
}

.search-box i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #f43f5e;
    font-size: 18px;
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
    font-weight: 800;
    color: #1e293b;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

th {
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    padding: 14px 16px;
    font-size: 13px;
    font-weight: 700;
    text-align: left;
}

th:first-child { border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
th:last-child { border-top-right-radius: 14px; border-bottom-right-radius: 14px; text-align: center; }

td {
    padding: 16px;
    font-size: 13px;
    color: #334155;
    border-bottom: 1px solid rgba(244, 63, 94, 0.08);
    vertical-align: middle;
}

td img {
    width: 75px;
    height: 55px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.06);
}

.badge-kategori {
    padding: 5px 14px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}

.badge-ibu {
    background: rgba(244, 63, 94, 0.12);
    color: #f43f5e;
}

.badge-bayi {
    background: rgba(14, 165, 233, 0.12);
    color: #0284c7;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}

.status-aktif {
    background: #dcfce7;
    color: #15803d;
}

.status-nonaktif {
    background: #fee2e2;
    color: #b91c1c;
}

.aksi {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.btn-action {
    padding: 7px 12px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    transition: 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-action.edit {
    background: #fef3c7;
    color: #b45309;
}

.btn-action.edit:hover {
    background: #fde68a;
}

.btn-action.hapus {
    background: #fee2e2;
    color: #b91c1c;
}

.btn-action.hapus:hover {
    background: #fca5a5;
    color: #7f1d1d;
}
</style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar_bidan') ?>

<div class="main">
<div class="layanan-container">

<div class="topbar">
    <div>
        <h1>Kelola Layanan Klinik</h1>
        <p>Tambah, perbarui, dan kontrol ketersediaan paket medis</p>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div style="background:#dcfce7; color:#15803d; border-left:4px solid #10b981; padding:14px 20px; border-radius:14px; margin-bottom:25px; font-weight:600; font-size:14px;">
    <i class='bx bx-check-circle'></i> <?= esc(session()->getFlashdata('success')); ?>
</div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<div style="background:#fee2e2; color:#b91c1c; border-left:4px solid #ef4444; padding:14px 20px; border-radius:14px; margin-bottom:25px; font-weight:600; font-size:14px;">
    <i class='bx bx-error-circle'></i> <?= esc(session()->getFlashdata('error')); ?>
</div>
<?php endif; ?>

<div class="stats">
    <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
        <div class="stat">
            <div>
                <h3><?= esc((string)$total) ?></h3>
                <p>Total Layanan</p>
            </div>
            <i class='bx bx-heart'></i>
        </div>
    </div>

    <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
        <div class="stat">
            <div>
                <h3><?= esc((string)$ibu) ?></h3>
                <p>Layanan Ibu</p>
            </div>
            <i class='bx bx-female'></i>
        </div>
    </div>

    <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
        <div class="stat">
            <div>
                <h3><?= esc((string)$bayi) ?></h3>
                <p>Layanan Bayi</p>
            </div>
            <i class='bx bx-child'></i>
        </div>
    </div>
</div>

<div class="action-bar">
    <div class="action-left">
        <a href="<?= base_url('tambah_layanan') ?>" class="btn-tambah">
            <i class='bx bx-plus-circle'></i>
            Tambah Layanan Baru
        </a>

        <?php $aktif = $filter; ?>
        <div class="filter-box">
            <div class="slider <?= ($aktif == '') ? 'left' : (($aktif == 'ibu') ? 'middle' : 'right') ?>"></div>

            <a href="<?= base_url('kelola_layanan') . '?search=' . urlencode($search) ?>"
               class="filter-btn <?= ($aktif == '') ? 'active-filter' : '' ?>">
               Semua
            </a>

            <a href="<?= base_url('kelola_layanan') . '?kategori=ibu&search=' . urlencode($search) ?>"
               class="filter-btn <?= ($aktif == 'ibu') ? 'active-filter' : '' ?>">
               Ibu
            </a>

            <a href="<?= base_url('kelola_layanan') . '?kategori=bayi&search=' . urlencode($search) ?>"
               class="filter-btn <?= ($aktif == 'bayi') ? 'active-filter' : '' ?>">
               Bayi
            </a>
        </div>
    </div>

    <div class="action-right">
        <form action="<?= base_url('kelola_layanan') ?>" method="GET" class="search-box">
            <?php if (!empty($filter)): ?>
                <input type="hidden" name="kategori" value="<?= esc($filter) ?>">
            <?php endif; ?>
            <i class='bx bx-search'></i>
            <input
                type="text"
                name="search"
                placeholder="Cari nama layanan..."
                value="<?= esc($search) ?>"
            >
        </form>
    </div>
</div>

<div class="table-box">
    <h3>Daftar Seluruh Layanan Medis</h3>
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama Layanan</th>
                <th>Kategori</th>
                <th>Biaya / Tarif</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($layanan)): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                    Tidak ada data layanan yang sesuai filter.
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($layanan as $d): ?>
            <tr>
                <td>
                    <img src="<?= base_url('assets/layanan/' . (!empty($d['gambar']) ? $d['gambar'] : 'default.png')) ?>" alt="Foto">
                </td>
                <td style="font-weight:700; color:#1e293b;">
                    <?= esc($d['nama_layanan'] ?? '-') ?>
                </td>
                <td>
                    <?php
                    $kategori = strtolower(trim($d['kategori'] ?? ''));
                    if ($kategori === 'ibu') {
                        echo '<span class="badge-kategori badge-ibu">Ibu</span>';
                    } elseif ($kategori === 'bayi') {
                        echo '<span class="badge-kategori badge-bayi">Bayi</span>';
                    } else {
                        echo '<span class="badge-kategori" style="background:#f1f5f9;color:#64748b;">' . esc(ucfirst($kategori)) . '</span>';
                    }
                    ?>
                </td>
                <td style="font-weight:700; color:#f43f5e;">
                    Rp<?= number_format($d['harga'] ?? 0, 0, ',', '.') ?>
                </td>
                <td>
                    <i class='bx bx-time-five' style="color:#64748b;"></i> <?= esc($d['durasi'] ?? '-') ?>
                </td>
                <td>
                    <?php $status = strtolower(trim($d['status'] ?? '')); ?>
                    <?php if ($status === 'aktif'): ?>
                        <span class="status-badge status-aktif">Aktif</span>
                    <?php else: ?>
                        <span class="status-badge status-nonaktif"><?= esc(ucfirst($d['status'] ?? 'Draft')) ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="aksi">
                        <a class="btn-action edit" href="<?= base_url('edit_layanan/' . ($d['id'] ?? 0)) ?>">
                            <i class='bx bx-edit-alt'></i> Edit
                        </a>
                        <a class="btn-action hapus" onclick="return confirm('Hapus layanan medis ini?')" href="<?= base_url('hapus_layanan/' . ($d['id'] ?? 0)) ?>">
                            <i class='bx bx-trash'></i> Hapus
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
setInterval(() => {
    fetch("<?= base_url('bidan/updateLastSeen') ?>");
}, 5000);
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
