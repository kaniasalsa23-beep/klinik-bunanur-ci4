<?php

$sessionBidan = session()->get('bidan');

$foto = !empty($sessionBidan['foto'])
    ? base_url('assets/profile/' . $sessionBidan['foto'])
    : base_url('assets/profile/default.png');

$namaBidan = $sessionBidan['nama'] ?? 'Bidan';

$online = !empty($sessionBidan);

$page = service('uri')->getSegment(1);

?>
<!-- ================= ELEGANT PINK MEDICAL GLASSMORPHISM SIDEBAR BIDAN (LIGHT MODE) ================= -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
.sidebar-container, .sidebar-container * { 
    box-sizing: border-box; 
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.sidebar-container {
    width: 260px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding: 24px 16px;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-right: 1.5px solid rgba(244, 63, 94, 0.16);
    display: flex;
    flex-direction: column;
    box-shadow: 12px 0 45px rgba(244, 63, 94, 0.08), 4px 0 16px rgba(0, 0, 0, 0.02);
    z-index: 1000;
    color: #1e293b;
    transition: all 0.3s ease;
}

@media(max-width: 992px) {
    .sidebar-container { width: 85px; padding: 20px 10px; }
    .brand-text, .user-info, .nav-item span, .nav-label, .btn-logout span, .btn-home span {
        display: none !important;
    }
    .brand-wrapper, .user-card, .nav-item, .btn-logout, .btn-home {
        justify-content: center;
        padding: 12px 0;
    }
}

/* BRAND LOGO */
.brand-wrapper {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 6px 22px;
    border-bottom: 1px solid rgba(244, 63, 94, 0.12);
    margin-bottom: 20px;
}

.brand-wrapper img {
    width: 48px; 
    height: 48px;
    background: #ffffff;
    padding: 6px;
    border-radius: 16px;
    border: 1.5px solid rgba(244, 63, 94, 0.3);
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.15);
    object-fit: contain;
}

.brand-text h2 { 
    font-family: 'Outfit', sans-serif;
    font-size: 20px; 
    font-weight: 800; 
    margin: 0; 
    letter-spacing: 0.5px;
    color: #4c0519;
}

.brand-text p { 
    font-size: 11px; 
    color: #f43f5e; 
    margin: 0; 
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
}

/* PROFILE CARD */
.user-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 14px 16px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    box-shadow: 0 8px 24px rgba(244, 63, 94, 0.06);
}

.user-card img {
    width: 52px; 
    height: 52px;
    border-radius: 50%; 
    object-fit: cover;
    border: 2px solid #f43f5e;
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
    flex-shrink: 0; 
}

.user-info h3 {
    font-size: 14.5px;
    font-weight: 700;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 140px;
    color: #1e293b;
}

/* STATUS INDICATOR */
.status-indicator {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11.5px;
    margin-top: 4px;
    font-weight: 700;
}

.dot { 
    width: 8px; 
    height: 8px; 
    border-radius: 50%; 
}

.dot-online { 
    background: #10b981; 
    box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
}
.text-online { color: #059669; }

.dot-offline { 
    background: #94a3b8; 
}
.text-offline { color: #94a3b8; }

/* NAVIGATION MENU */
.nav-list {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
    overflow-y: auto;
}

.nav-label {
    font-size: 11px;
    font-weight: 800;
    color: #9f1239;
    letter-spacing: 1.5px;
    margin: 0 0 8px 10px;
    text-transform: uppercase;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 11px 16px;
    text-decoration: none;
    color: #64748b;
    font-size: 14.5px;
    font-weight: 600;
    border-radius: 16px;
    border: 1px solid transparent;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.nav-item i {
    font-size: 21px;
    transition: transform 0.25s ease;
    color: #94a3b8;
}

.nav-item:hover {
    background: #fff1f2;
    color: #be123c;
    transform: translateX(4px);
    border-color: rgba(244, 63, 94, 0.2);
}

.nav-item:hover i {
    transform: scale(1.15);
    color: #f43f5e;
}

.nav-item.active {
    background: linear-gradient(135deg, rgba(244, 63, 94, 0.14) 0%, rgba(236, 72, 153, 0.08) 100%);
    color: #be123c;
    font-weight: 800;
    border: 1.5px solid rgba(244, 63, 94, 0.35);
    box-shadow: 0 6px 18px rgba(244, 63, 94, 0.12);
}

.nav-item.active i {
    color: #f43f5e;
}

/* LOGOUT SECTION */
.footer-nav { 
    margin-top: auto; 
    padding-top: 16px; 
    border-top: 1px solid rgba(244, 63, 94, 0.12);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.btn-logout {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: rgba(244, 63, 94, 0.08);
    border-radius: 16px;
    text-decoration: none;
    color: #e11d48;
    font-weight: 700;
    font-size: 13.5px;
    border: 1.5px solid rgba(244, 63, 94, 0.22);
    transition: all 0.25s ease;
}

.btn-logout:hover { 
    background: #fff1f2; 
    border-color: #f43f5e;
    color: #be123c;
    box-shadow: 0 4px 14px rgba(244, 63, 94, 0.18);
    transform: translateY(-2px);
}

.btn-home {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.85);
    border-radius: 16px;
    text-decoration: none;
    color: #475569;
    font-weight: 700;
    font-size: 13.5px;
    border: 1.5px solid rgba(244, 63, 94, 0.18);
    transition: all 0.25s ease;
}

.btn-home:hover {
    background: #fff1f2;
    color: #be123c;
    border-color: #f43f5e;
    box-shadow: 0 4px 14px rgba(244, 63, 94, 0.15);
    transform: translateY(-2px);
}

/* CONTENT ADAPTATION & TOP ALIGNMENT */
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

.dashboard-inner-container, .pasien-container, .layanan-container, 
.kunjungan-container, .testimoni-container, .profil-bidan-container, 
.konsultasi-bidan-container, .inner-container {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.header-box, .header-container, .topbar {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

.header-box h1, .header-box h2, .header-container h1, .header-container h2, .topbar h1, .topbar h2 {
    margin-top: 0 !important;
}

@media(max-width: 992px) {
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

<aside class="sidebar-container">
    <div class="brand-wrapper">
        <img src="<?= base_url('assets/Logo.png') ?>" alt="Logo Bunanur Clinic">
        <div class="brand-text">
            <h2>BUNANUR</h2>
            <p>Clinical Control</p>
        </div>
    </div>

    <div class="user-card">
        <img src="<?= $foto ?>" alt="Bidan Profil" onerror="this.src='<?= base_url('assets/profile/default.png') ?>'">
        <div class="user-info">
            <h3><?= esc($namaBidan) ?></h3>
            <div class="status-indicator">
                <span class="dot <?= $online ? 'dot-online' : 'dot-offline' ?>"></span>
                <span class="<?= $online ? 'text-online' : 'text-offline' ?>">
                    <?= $online ? 'Online Aktif' : 'Offline' ?>
                </span>
            </div>
        </div>
    </div>

    <p class="nav-label">Navigasi Medis</p>
    
    <nav class="nav-list">
        <a href="<?= site_url('dashboard_bidan') ?>" class="nav-item <?= ($page=='dashboard_bidan') ? 'active' : '' ?>">
            <i class='bx bxs-dashboard'></i><span>Dashboard</span>
        </a>
        <a href="<?= site_url('kelola_layanan') ?>" class="nav-item <?=($page=='kelola_layanan')?'active':'';?>">
            <i class='bx bxs-shield-plus'></i><span>Kelola Layanan</span>
        </a>
        <a href="<?= site_url('pasien_aktif') ?>" class="nav-item <?=($page=='pasien_aktif')?'active':'';?>">
            <i class='bx bxs-group'></i><span>Pasien Aktif</span>
        </a>
        <a href="<?= site_url('konsultasi_bidan') ?>" class="nav-item <?=($page=='konsultasi_bidan')?'active':'';?>">
            <i class='bx bxs-chat'></i><span>Konsultasi</span>
        </a>
        <a href="<?= site_url('kunjungan_bidan') ?>" class="nav-item <?=($page=='kunjungan_bidan')?'active':'';?>">
            <i class='bx bxs-calendar-check'></i><span>Jadwal Kunjungan</span>
        </a>
        <a href="<?= site_url('testimoni_bidan') ?>" class="nav-item <?=($page=='testimoni_bidan')?'active':'';?>">
            <i class='bx bxs-star'></i><span>Ulasan Pasien</span>
        </a>
        <a href="<?= site_url('edit_profil_bidan') ?>" class="nav-item <?=($page=='edit_profil_bidan')?'active':'';?>">
            <i class='bx bxs-user-detail'></i><span>Profil Medis</span>
        </a>
    </nav>

    <div class="footer-nav">
        <a href="<?= site_url('logout_bidan') ?>" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin keluar dari portal bidan?')">
            <i class='bx bx-power-off'></i><span>Keluar / Logout</span>
        </a>
        <a href="<?= base_url('/') ?>" class="btn-home">
            <i class='bx bx-home-heart'></i><span>Beranda Utama</span>
        </a>
    </div>
</aside>
