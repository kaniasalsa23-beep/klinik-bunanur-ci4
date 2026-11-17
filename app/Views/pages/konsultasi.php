<?php

$pasien = $pasien ?? [];

$foto_pasien = $pasien['foto'] ?? 'default-hero.png';
$nama_pasien = $pasien['nama'] ?? '';
$no_hp_pasien = $pasien['no_hp'] ?? '';

$bidan = $bidan ?? [];
$online_bidan = $online_bidan ?? false;

$total_pesan_pasien = $total_pesan_pasien ?? 0;
$limit_maksimal = $limit_maksimal ?? 10;

$chat = $chat ?? [];

$raw_wa = !empty($bidan['whatsapp']) ? $bidan['whatsapp'] : (!empty($bidan['no_hp']) ? $bidan['no_hp'] : '081224841377');
$clean_wa = preg_replace('/[^0-9]/', '', (string)$raw_wa);
if (str_starts_with($clean_wa, '0')) {
    $no_wa_bidan = '62' . substr($clean_wa, 1);
} elseif (str_starts_with($clean_wa, '62')) {
    $no_wa_bidan = $clean_wa;
} else {
    $no_wa_bidan = '62' . $clean_wa;
}
$wa_url = 'https://wa.me/' . $no_wa_bidan . '?text=' . urlencode('Halo Bidan, saya ingin konsultasi medis lanjutan atas nama ' . ($nama_pasien ?: 'Pasien'));

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Konsultasi Pasien - Bunanur Medical</title>

<!-- Master Glassmorphism 3D CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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

.konsultasi-container {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

@media(max-width: 992px) {
    .main {
        margin-left: 85px;
        width: calc(100% - 85px);
        padding: 24px 20px;
        padding-top: 24px !important;
    }
}

@media(max-width: 576px) {
    .main {
        margin-left: 0;
        width: 100%;
        padding: 20px 14px;
        padding-top: 20px !important;
    }
}

.topbar {
    margin-top: 0 !important;
    padding-top: 0 !important;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.topbar h2 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    letter-spacing: -0.5px;
    margin-top: 0 !important;
}

.topbar p {
    margin-top: 6px;
    color: #64748b;
    font-size: 14px;
}

/* STATS CARDS */
.info-box {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 22px;
    margin-bottom: 30px;
}

.info-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    padding: 24px 28px;
    border-radius: 24px;
    box-shadow: 0 12px 30px -8px rgba(244, 63, 94, 0.08);
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 35px -8px rgba(244, 63, 94, 0.15);
}

.info-card .icon-wrap {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(244, 63, 94, 0.12), rgba(236, 72, 153, 0.18));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #f43f5e;
}

.info-card h3 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 4px;
    line-height: 1;
}

.info-card span {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
}

/* CHAT WRAPPER */
.chat-wrapper {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
    display: flex;
    flex-direction: column;
    height: 680px;
}

.chat-header {
    padding: 22px 30px;
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(244, 63, 94, 0.25);
}

.chat-header h3 {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -0.3px;
}

.chat-badge {
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(8px);
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* CHAT BOX */
.chat-box {
    flex: 1;
    overflow-y: auto;
    padding: 30px;
    background: rgba(255, 255, 255, 0.45);
    display: flex;
    flex-direction: column;
    gap: 16px;
    scroll-behavior: smooth;
}

.chat-box::-webkit-scrollbar {
    width: 6px;
}

.chat-box::-webkit-scrollbar-thumb {
    background: rgba(244, 63, 94, 0.25);
    border-radius: 20px;
}

.bubble {
    max-width: 70%;
    padding: 14px 18px;
    font-size: 14px;
    line-height: 1.6;
    word-wrap: break-word;
    position: relative;
    animation: fadeIn .25s ease;
}

/* PASIEN (KANAN) */
.bubble.user {
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    align-self: flex-end;
    border-radius: 20px 20px 4px 20px;
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.28);
}

/* BIDAN (KIRI) */
.bubble.admin {
    background: rgba(255, 255, 255, 0.96);
    color: #1e293b;
    align-self: flex-start;
    border-radius: 20px 20px 20px 4px;
    border: 1px solid rgba(244, 63, 94, 0.12);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
}

.cek {
    font-size: 11px;
    margin-top: 4px;
    text-align: right;
    opacity: 0.85;
}

.bubble.user .cek {
    color: rgba(255, 255, 255, 0.85);
}

.bubble.user .cek.read {
    color: #38bdf8;
    font-weight: 700;
}

/* INPUT */
.chat-input {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    padding: 20px 25px;
    border-top: 1px solid rgba(244, 63, 94, 0.12);
}

.chat-input textarea {
    width: 100%;
    height: 75px;
    padding: 14px 18px;
    border-radius: 18px;
    border: 1.5px solid rgba(244, 63, 94, 0.20);
    background: white;
    font-family: inherit;
    font-size: 14px;
    color: #1e293b;
    transition: all 0.3s ease;
    resize: none;
    outline: none;
}

.chat-input textarea:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
}

.chat-input button {
    width: 100%;
    margin-top: 12px;
    border: none;
    padding: 14px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.25);
    transition: all 0.3s ease;
}

.chat-input button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(244, 63, 94, 0.35);
}

.limit {
    margin-top: 8px;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
}

.limit-box {
    padding: 25px;
    text-align: center;
}

.limit-box h3 {
    color: #1e293b;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
}

.limit-box p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
}

.wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 14px;
    padding: 12px 26px;
    background: #10b981;
    color: white;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.25);
    transition: all 0.3s ease;
}

.wa-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(16, 185, 129, 0.35);
}

.limit-warning {
    margin: 12px 20px;
    background: #fffbeb;
    color: #b45309;
    padding: 12px 18px;
    border-radius: 14px;
    border-left: 4px solid #f59e0b;
    font-size: 13px;
    font-weight: 600;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar') ?>

<div class="main">
    <div class="konsultasi-container">

    <div class="topbar">
        <div>
            <h2>Konsultasi Bidan</h2>
            <p>Diskusikan keluhan kesehatan Anda bersama bidan terpercaya.</p>
        </div>
    </div>

    <div class="info-box">
        <div class="info-card" data-tilt data-tilt-max="6" data-tilt-glare="true" data-tilt-max-glare="0.2">
            <div class="icon-wrap">
                <i class='bx bx-chat'></i>
            </div>
            <div>
                <h3><?= $total_pesan_pasien ?></h3>
                <span>Pesan Terkirim</span>
            </div>
        </div>

        <div class="info-card" data-tilt data-tilt-max="6" data-tilt-glare="true" data-tilt-max-glare="0.2">
            <div class="icon-wrap" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(16, 185, 129, 0.22)); color: #10b981;">
                <i class='bx bx-layer'></i>
            </div>
            <div>
                <h3><?= ($limit_maksimal - $total_pesan_pasien > 0) ? $limit_maksimal - $total_pesan_pasien : 0 ?></h3>
                <span>Sisa Kuota Pesan</span>
            </div>
        </div>
    </div>

    <div class="chat-wrapper">
        <div class="chat-header">
            <h3><i class='bx bx-message-rounded-dots'></i> Chat Konsultasi Medis</h3>
            <div class="chat-badge">Maksimal <?= $limit_maksimal ?> pesan gratis</div>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div style="background:#fee2e2; color:#b91c1c; padding:12px 20px; margin:15px; border-radius:12px; font-weight:600; font-size:13px; border:1px solid #fca5a5;">
                <i class='bx bx-error-circle'></i> <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div style="background:#dcfce7; color:#15803d; padding:12px 20px; margin:15px; border-radius:12px; font-weight:600; font-size:13px; border:1px solid #86efac;">
                <i class='bx bx-check-circle'></i> <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <div class="chat-box" id="chatContainer">
            <?php if(empty($chat)): ?>
                <div class="bubble admin">
                    👋 Halo, selamat datang di layanan konsultasi BUNANUR.
                    Silakan sampaikan keluhan atau pertanyaan Anda, bidan kami siap membantu.
                </div>
            <?php else: ?>
                <?php foreach($chat as $c): ?>
                    <?php $pengirim = $c['pengirim'] ?? 'user'; ?>

                    <?php if($pengirim == 'bidan'): ?>
                        <div style="display:flex; align-items:flex-end; gap:10px; margin-bottom:10px;">
                            <img
                                src="<?= base_url('assets/profile/' . ($bidan['foto'] ?? 'default-hero.png')) ?>"
                                style="width:36px; height:36px; border-radius:50%; object-fit:cover; border:2px solid #f43f5e; box-shadow:0 4px 10px rgba(0,0,0,0.06);"
                            >
                            <div class="bubble admin">
                                <?= nl2br(esc($c['pesan'])) ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="display:flex; justify-content:flex-end; align-items:flex-end; gap:10px; margin-bottom:10px;">
                            <div class="bubble user">
                                <?= nl2br(esc($c['pesan'])) ?>
                                <?php $statusBaca = $c['status_baca'] ?? ''; ?>
                                <div class="cek <?= ($statusBaca == 'dibaca') ? 'read' : '' ?>">
                                    <?= ($statusBaca == 'dibaca') ? '✓✓' : '✓' ?>
                                </div>
                            </div>
                            <img
                                src="<?= base_url('assets/profile/' . $foto_pasien) ?>"
                                style="width:36px; height:36px; border-radius:50%; object-fit:cover; border:2px solid #fff; box-shadow:0 4px 10px rgba(0,0,0,0.06);"
                            >
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if($total_pesan_pasien >= 7 && $total_pesan_pasien < $limit_maksimal): ?>
                <div class="bubble admin" style="border-left: 3px solid #f59e0b;">
                    ⚠️ Kuota kirim pesan Anda tersisa <b><?= $limit_maksimal - $total_pesan_pasien ?></b> kali lagi.
                </div>
            <?php endif; ?>

            <?php if($total_pesan_pasien >= $limit_maksimal): ?>
                <div class="bubble admin" style="border-left: 3px solid #f43f5e;">
                    ❌ Batas kirim pesan gratis (<?= $limit_maksimal ?> pesan) telah tercapai. Untuk konsultasi berkelanjutan, silakan terhubung via WhatsApp:
                    <br><br>
                    <a href="<?= esc($wa_url, 'attr') ?>" target="_blank" class="wa-btn">
                        <i class='bx bxl-whatsapp'></i> Lanjut via WhatsApp
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if(($limit_maksimal - $total_pesan_pasien) <= 3 && $total_pesan_pasien < $limit_maksimal): ?>
            <div class="limit-warning">
                ⚠️ Sisa kuota konsultasi Anda tinggal <b><?= $limit_maksimal - $total_pesan_pasien ?></b> pesan lagi.
            </div>
        <?php endif; ?>

        <div class="chat-input">
            <?php if($total_pesan_pasien < $limit_maksimal): ?>
                <form method="POST" action="<?= site_url('kirim_chat') ?>">
                    <?= csrf_field() ?>
                    <textarea name="pesan" placeholder="Tulis pertanyaan atau keluhan kesehatan Anda..." required></textarea>
                    <button type="submit" name="kirim">
                        <i class='bx bx-send'></i> Kirim Pesan Konsultasi
                    </button>
                </form>
                <p class="limit">Sisa kuota gratis: <?= $limit_maksimal - $total_pesan_pasien ?> pesan</p>
            <?php else: ?>
                <div class="limit-box">
                    <h3>Batas Kirim Pesan Telah Habis</h3>
                    <p>Anda telah memanfaatkan seluruh kuota konsultasi gratis (<?= $limit_maksimal ?> pesan). Silakan hubungi langsung via WhatsApp.</p>
                    <a href="<?= esc($wa_url, 'attr') ?>" target="_blank" class="wa-btn">
                        <i class='bx bxl-whatsapp'></i> Hubungi via WhatsApp
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </div>
</div>

<!-- 3D Scripts -->
<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
const chatBox = document.getElementById('chatContainer');
if(chatBox){
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>
</body>
</html>
