<?php

$pasien  = $pasien ?? [];
$layanan = $layanan ?? [];
$request = service('request');

if (empty($layanan)) {
    throw new \Exception('Data layanan tidak ditemukan');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajukan Kunjungan - Bunanur Medical</title>

<!-- Master Glassmorphism 3D CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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

.booking-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

@media (max-width: 992px) {
    .main { margin-left: 85px; width: calc(100% - 85px); padding: 24px 20px; padding-top: 24px !important; }
}

@media (max-width: 576px) {
    .main { margin-left: 0; width: 100%; padding: 20px 14px; padding-top: 20px !important; }
}

.page-header {
    margin-top: 0 !important;
    padding-top: 0 !important;
    margin-bottom: 35px;
}

.page-header h1 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.5px;
    margin-top: 0 !important;
}
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.5px;
}

.page-header p {
    color: #64748b;
    font-size: 14px;
    margin-top: 4px;
}

/* LAYOUT 2 KOLOM */
.booking-layout {
    display: grid;
    grid-template-columns: 1fr 1.3fr;
    gap: 35px;
}

@media (max-width: 992px) {
    .booking-layout { grid-template-columns: 1fr; }
}

/* LEFT SIDE */
.booking-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-card {
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: white;
    padding: 35px;
    border-radius: 28px;
    box-shadow: 0 15px 35px -5px rgba(244, 63, 94, 0.35);
    position: relative;
    overflow: hidden;
}

.info-card::after {
    content: '';
    position: absolute;
    width: 220px;
    height: 220px;
    background: rgba(255, 255, 255, 0.12);
    border-radius: 50%;
    top: -80px;
    right: -50px;
    pointer-events: none;
}

.info-card h2 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 8px;
}

.info-card p {
    font-size: 13px;
    opacity: 0.9;
    line-height: 1.5;
}

.info-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.25);
    font-weight: 700;
    font-size: 15px;
}

.info-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.info-benefit {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 24px;
    border-radius: 22px;
    box-shadow: 0 10px 25px rgba(244, 63, 94, 0.06);
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}

.benefit-item i {
    color: #10b981;
    font-size: 18px;
}

.clinic-address {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 24px;
    border-radius: 22px;
    box-shadow: 0 10px 25px rgba(244, 63, 94, 0.06);
    font-size: 13px;
    line-height: 1.6;
    color: #475569;
}

.clinic-address strong {
    color: #f43f5e;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}

/* RIGHT SIDE FORM */
.form-container {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 35px;
    border-radius: 30px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
}

.section {
    margin-bottom: 24px;
}

.section h3 {
    font-size: 14px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}

.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

@media(max-width: 600px) {
    .grid { grid-template-columns: 1fr; }
}

.custom-input {
    width: 100%;
    padding: 14px 18px;
    border-radius: 14px;
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    background: rgba(255, 255, 255, 0.9);
    font-family: inherit;
    font-size: 14px;
    color: #1e293b;
    outline: none;
    transition: all 0.3s ease;
}

.custom-input:focus {
    border-color: #f43f5e;
    background: white;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
}

textarea.custom-input {
    min-height: 90px;
    resize: none;
}

.input-split {
    display: flex;
    background: rgba(255, 255, 255, 0.9);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    border-radius: 14px;
    overflow: hidden;
    height: 50px;
    transition: all 0.3s ease;
}

.input-split:focus-within {
    border-color: #f43f5e;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
    background: white;
}

.input-split input {
    flex: 1;
    border: none;
    padding: 0 16px;
    outline: none;
    font-size: 14px;
    font-family: inherit;
    background: transparent;
}

.input-split select {
    border: none;
    background: rgba(244, 63, 94, 0.05);
    padding: 0 12px;
    font-size: 13px;
    font-weight: 600;
    color: #f43f5e;
    outline: none;
    cursor: pointer;
}

.action-bar {
    display: flex;
    gap: 14px;
    margin-top: 30px;
}

.btn-back {
    flex: 1;
    padding: 14px;
    border-radius: 14px;
    background: #f1f5f9;
    color: #64748b;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    text-align: center;
    transition: 0.3s;
}

.btn-back:hover {
    background: #e2e8f0;
    color: #334155;
}

.btn-submit {
    flex: 2;
    padding: 14px 20px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: white;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(244, 63, 94, 0.28);
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(244, 63, 94, 0.38);
}
</style>
</head>

<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar') ?>

<div class="main">
    <div class="booking-container">

    <div class="page-header">
        <h1>Ajukan Kunjungan Medis</h1>
        <p>Pelayanan cepat, ramah, dan profesional untuk kesehatan ibu & buah hati Anda</p>
    </div>

    <div class="booking-layout">

        <!-- LEFT SIDE -->
        <div class="booking-info">
            <div class="info-card" data-tilt data-tilt-max="6" data-tilt-glare="true" data-tilt-max-glare="0.2">
                <h2><?= esc($layanan['nama_layanan']); ?></h2>
                <p>Layanan medis prima berstandar klinik kebidanan modern.</p>

                <div class="info-meta">
                    <span><i class='bx bx-wallet'></i> Rp<?= number_format($layanan['harga'] ?? 0, 0, ',', '.'); ?></span>
                    <span><i class='bx bx-time'></i> <?= esc($layanan['durasi']); ?></span>
                </div>
            </div>

            <div class="info-benefit">
                <div class="benefit-item">
                    <i class='bx bxs-check-circle'></i>
                    <span>Ditangani langsung oleh Bidan berpengalaman</span>
                </div>
                <div class="benefit-item">
                    <i class='bx bxs-check-circle'></i>
                    <span>Waktu dan antrean terjadwal teratur</span>
                </div>
                <div class="benefit-item">
                    <i class='bx bxs-check-circle'></i>
                    <span>Peralatan higienis dan steril berstandar medis</span>
                </div>
            </div>

            <div class="clinic-address">
                <strong><i class='bx bx-map-pin'></i> Lokasi Klinik BUNANUR</strong>
                Dusun Senen RT 04/RW 01 Desa Karangkancana<br>
                (Masuk area MTS Terpadu Riyadul Badiah)
            </div>
        </div>

        <!-- RIGHT SIDE FORM -->
        <div class="form-container">
            <form method="POST" action="<?= base_url('ajukan_kunjungan/proses'); ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="layanan" value="<?= esc($layanan['id']); ?>">

                <div class="section">
                    <h3>Data Pasien</h3>
                    <div class="grid">
                        <input type="text" name="nama" 
                               value="<?= esc($pasien['nama'] ?? '') ?>" 
                               placeholder="Nama Lengkap Pasien" 
                               class="custom-input" required>

                        <div class="input-split">
                            <input type="number" name="usia" placeholder="Usia" required min="1">
                            <select name="satuan_usia" required>
                                <option value="Thn">Tahun</option>
                                <option value="Bln">Bulan</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-split" style="margin-top: 14px;">
                        <select name="kategori_pendamping" required style="border-right: 1.5px solid rgba(244, 63, 94, 0.16);">
                            <option value="Suami">Suami</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Ayah">Ayah</option>
                            <option value="Wali">Wali</option>
                        </select>
                        <input type="text" name="ortu" placeholder="Nama Lengkap Pendamping / Wali" required>
                    </div>
                </div>

                <div class="section">
                    <h3>Pilih Tanggal & Waktu Layanan</h3>
                    <div class="grid">
                        <input type="date"
                               id="tanggalInput"
                               name="tanggal"
                               min="<?= date('Y-m-d'); ?>"
                               value="<?= esc($request->getGet('tanggal') ?? date('Y-m-d'), 'attr'); ?>"
                               class="custom-input"
                               required
                               onchange="window.location.href='<?= base_url('ajukan_kunjungan/' . (int)$layanan['id']) ?>?tanggal=' + encodeURIComponent(this.value)">

                        <select name="jam" required class="custom-input">
                            <option value="">Pilih Jam Layanan</option>
                            <?php
                            $list_jam = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '13:00:00', '14:00:00', '15:00:00'];
                            foreach ($list_jam as $j) {
                                $display_jam = substr($j, 0, 5);
                                echo "<option value='$j'>{$display_jam} WIB</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="section">
                    <h3>Alamat Domisili</h3>
                    <textarea name="alamat" class="custom-input" placeholder="Masukkan alamat lengkap (Dusun, RT/RW, Desa)..." required><?= esc($pasien['alamat'] ?? '') ?></textarea>
                </div>

                <div class="action-bar">
                    <a href="<?= base_url('layanan'); ?>" class="btn-back">
                        <i class='bx bx-left-arrow-alt'></i> Kembali
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class='bx bx-check-double'></i> Konfirmasi Kunjungan
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
</body>
</html>
