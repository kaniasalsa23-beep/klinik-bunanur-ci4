<?php

$db = \Config\Database::connect();
$session = session();

$pasien = $session->get('pasien');

if (!$pasien) {
    header('Location: ' . base_url('/'));
    exit;
}

$defaultFoto = 'default-hero.png';

if (
    !empty($pasien['foto']) &&
    file_exists(FCPATH . 'assets/profile/' . $pasien['foto'])
) {
    $foto = $pasien['foto'];
} else {
    $foto = $defaultFoto;
}

$page = uri_string();

$pasienData = $db->table('pasien')
    ->where('id', $pasien['id'])
    ->get()
    ->getRowArray();

if (
    !empty($pasienData['foto']) &&
    file_exists(FCPATH . 'assets/profile/' . $pasienData['foto'])
) {
    $foto = $pasienData['foto'];
} else {
    $foto = $defaultFoto;
}

// Status online pasien: Karena user memiliki sesi aktif pasien di sidebar miliknya sendiri, status SELALU 'Online'
$online_pasien = true;

// Sinkronisasi last_seen dan status di database pasien saat render
if (!empty($pasien['id'])) {
    $now = date('Y-m-d H:i:s');
    $sidebarUpdate = ['last_seen' => $now];
    if ($db->fieldExists('status', 'pasien')) {
        $sidebarUpdate['status'] = 'online';
    }
    $db->table('pasien')->where('id', $pasien['id'])->update($sidebarUpdate);
}
?>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
/* Reset & Base */
* { margin:0; padding:0; box-sizing:border-box; }

/* ===== ELEGANT PINK MEDICAL GLASSMORPHISM SIDEBAR (LIGHT MODE) ===== */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-right: 1.5px solid rgba(244, 63, 94, 0.16);
    box-shadow: 12px 0 40px rgba(244, 63, 94, 0.08), 4px 0 16px rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* LOGO / BRAND */
.brand-box {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 8px 22px;
    border-bottom: 1px solid rgba(244, 63, 94, 0.12);
    margin-bottom: 22px;
}

.brand-box img {
    width: 48px;
    height: 48px;
    background: #ffffff;
    padding: 6px;
    border-radius: 16px;
    border: 1.5px solid rgba(244, 63, 94, 0.3);
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.15);
}

.brand-box h3 {
    color: #4c0519;
    font-family: 'Outfit', sans-serif;
    font-size: 20px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.brand-box small {
    color: #f43f5e;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    display: block;
}

/* USER INFO CARD */
.user-box {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.9);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    box-shadow: 0 8px 24px rgba(244, 63, 94, 0.06);
    margin-bottom: 26px;
}

.user-box img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f43f5e;
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
}

.user-box div {
    overflow: hidden;
}

.user-box h4 {
    color: #1e293b;
    font-size: 14.5px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* STATUS STYLING */
.status-indicator {
    font-size: 11.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 3px;
}

.status-online { 
    color: #059669; 
}
.status-online .status-dot {
    color: #10b981;
    font-size: 10px;
    display: inline-block;
    filter: drop-shadow(0 0 4px rgba(16, 185, 129, 0.7));
}
.status-offline { 
    color: #94a3b8; 
}
.status-offline .status-dot {
    color: #94a3b8;
    font-size: 10px;
    display: inline-block;
}

/* MENU STYLING */
.menu-label {
    padding: 0 14px 10px;
    font-size: 11px;
    font-weight: 800;
    color: #9f1239;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.menu-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1;
}

.menu-list a {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 18px;
    border-radius: 16px;
    text-decoration: none;
    color: #64748b;
    font-size: 14.5px;
    font-weight: 600;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid transparent;
}

.menu-list a i {
    font-size: 21px;
    transition: transform 0.25s ease;
    color: #94a3b8;
}

/* Hover Effect */
.menu-list a:hover {
    background: #fff1f2;
    color: #be123c;
    transform: translateX(4px);
    border-color: rgba(244, 63, 94, 0.2);
}

.menu-list a:hover i {
    transform: scale(1.15);
    color: #f43f5e;
}

/* Active State */
.menu-list a.active {
    background: linear-gradient(135deg, rgba(244, 63, 94, 0.12) 0%, rgba(236, 72, 153, 0.08) 100%);
    color: #be123c;
    font-weight: 800;
    border: 1.5px solid rgba(244, 63, 94, 0.35);
    box-shadow: 0 6px 18px rgba(244, 63, 94, 0.12);
}

.menu-list a.active i {
    color: #f43f5e;
}

/* SIDEBAR BOTTOM */
.sidebar-bottom {
    margin-top: auto;
    padding-top: 18px;
    border-top: 1px solid rgba(244, 63, 94, 0.12);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-radius: 16px;
    background: rgba(244, 63, 94, 0.08);
    color: #e11d48;
    text-decoration: none;
    font-weight: 700;
    font-size: 13.5px;
    border: 1.5px solid rgba(244, 63, 94, 0.22);
    transition: all 0.25s ease;
}

.logout-btn:hover {
    background: #fff1f2;
    color: #be123c;
    border-color: #f43f5e;
    box-shadow: 0 4px 14px rgba(244, 63, 94, 0.18);
    transform: translateY(-2px);
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.85);
    color: #475569;
    text-decoration: none;
    font-weight: 700;
    font-size: 13.5px;
    border: 1.5px solid rgba(244, 63, 94, 0.18);
    transition: all 0.25s ease;
}

.back-btn:hover {
    background: #fff1f2;
    color: #be123c;
    border-color: #f43f5e;
    box-shadow: 0 4px 14px rgba(244, 63, 94, 0.15);
    transform: translateY(-2px);
}

/* CONTENT ADAPTATION */
.main, .main-content, .main-dashboard {
    margin-left: 260px !important;
    width: calc(100% - 260px) !important;
    padding: 24px 36px 36px !important;
    padding-top: 24px !important;
    margin-top: 0 !important;
    min-height: 100vh;
    box-sizing: border-box !important;
    transition: all 0.3s ease;
}

/* Zero top margin/padding for dashboard container & headings */
.dashboard-container, .inner-container, .content-container, .profil-container, .konsultasi-container, .riwayat-container {
    margin-top: 0 !important;
    padding-top: 0 !important;
}
.topbar, .topbar-cyber {
    margin-top: 0 !important;
    padding-top: 0 !important;
}
.topbar h1, .topbar h2, .topbar-cyber h1, .topbar-cyber h2 {
    margin-top: 0 !important;
}

/* RESPONSIVE (Tablet & Phone) */
@media(max-width: 992px) {
    .sidebar { width: 85px; padding: 22px 10px; }
    .brand-box h3, .brand-box small, .user-box div, 
    .menu-list a span, .menu-label, .back-btn span, .logout-btn span {
        display: none;
    }
    .brand-box, .user-box, .menu-list a, .back-btn, .logout-btn {
        justify-content: center;
        padding: 12px 0;
    }
    .user-box { padding: 8px; }
    .main, .main-content, .main-dashboard { 
        margin-left: 85px !important; 
        width: calc(100% - 85px) !important; 
        padding: 24px 20px 24px !important; 
        padding-top: 24px !important;
        margin-top: 0 !important;
    }
}

@media(max-width: 576px) {
    .main, .main-content, .main-dashboard {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 20px 14px 20px !important;
        padding-top: 20px !important;
        margin-top: 0 !important;
    }
}
</style>

<aside class="sidebar">
    <!-- BRAND -->
    <div class="brand-box">
        <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Bunanur">
        <div>
            <h3>BUNANUR</h3>
            <small>Mother Care Portal</small>
        </div>
    </div>

    <!-- USER INFO -->
    <div class="user-box">
        <img src="<?= base_url('assets/profile/' . $foto) ?>" alt="Foto Pasien" onerror="this.src='<?= base_url('assets/profile/default-hero.png') ?>'">
        <div>
            <h4><?= esc($pasien['nama'] ?? 'Pasien'); ?></h4>
            <div class="status-indicator <?= $online_pasien ? 'status-online' : 'status-offline' ?>" id="patientStatusBadge">
                <span class="status-dot">●</span> <span id="patientStatusLabel"><?= $online_pasien ? 'Online' : 'Offline' ?></span>
            </div>
        </div>
    </div>

    <div class="menu-label">Menu Pasien</div>

    <nav class="menu-list">
        <a href="<?= base_url('dashboard_pasien') ?>"
           class="<?= ($page == 'dashboard_pasien') ? 'active' : '' ?>">
            <i class='bx bx-grid-alt'></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= base_url('konsultasi') ?>"
           class="<?= ($page == 'konsultasi') ? 'active' : '' ?>">
            <i class='bx bx-message-rounded-dots'></i>
            <span>Konsultasi</span>
        </a>

        <a href="<?= base_url('layanan') ?>"
           class="<?= ($page == 'layanan') ? 'active' : '' ?>">
            <i class='bx bx-plus-medical'></i>
            <span>Layanan Medis</span>
        </a>

        <a href="<?= base_url('riwayat') ?>"
           class="<?= ($page == 'riwayat') ? 'active' : '' ?>">
            <i class='bx bx-history'></i>
            <span>Riwayat Kunjungan</span>
        </a>

        <a href="<?= base_url('profil') ?>"
           class="<?= ($page == 'profil') ? 'active' : '' ?>">
            <i class='bx bx-user'></i>
            <span>Profil Akun</span>
        </a>
    </nav>

    <div class="sidebar-bottom">
        <a href="<?= base_url('logout') ?>" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')">
            <i class='bx bx-power-off'></i>
            <span>Keluar / Logout</span>
        </a>
        <a href="<?= base_url('/') ?>" class="back-btn">
            <i class='bx bx-home-heart'></i>
            <span>Beranda Utama</span>
        </a>
    </div>
</aside>

<script>
// Heartbeat Otomatis Status Online Pasien
(function() {
    function pingPasienOnline() {
        if (navigator.onLine) {
            fetch("<?= base_url('pasien/updateLastSeen') ?>", {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-store'
            }).then(function(res) {
                return res.json();
            }).then(function(data) {
                var badge = document.getElementById('patientStatusBadge');
                var label = document.getElementById('patientStatusLabel');
                if (badge && label && data.status === 'ok') {
                    badge.classList.remove('status-offline');
                    badge.classList.add('status-online');
                    label.textContent = 'Online';
                }
            }).catch(function(err) {
                // Background heartbeat fallback
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            pingPasienOnline();
            setInterval(pingPasienOnline, 15000);
        });
    } else {
        pingPasienOnline();
        setInterval(pingPasienOnline, 15000);
    }
})();
</script>
