<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Konsultasi Pasien - Bunanur Medical Center</title>

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

.konsultasi-bidan-container {
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
    padding: 12px;
    border-radius: 18px;
}

/* LIST CONVERSATION */
.list-full {
    width: 100%;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    border-radius: 28px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
    overflow: hidden;
}

.conversation-row {
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(244, 63, 94, 0.08);
    transition: background 0.25s ease;
}

.conversation-row:hover {
    background: rgba(244, 63, 94, 0.04);
}

.list-item {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 20px 25px;
    text-decoration: none;
    color: #1e293b;
    flex: 1;
}

.list-item img {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 4px 12px rgba(244, 63, 94, 0.15);
}

.list-info {
    flex: 1;
}

.list-info-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}

.list-info h3 {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.list-info small {
    font-size: 12px;
    font-weight: 600;
    color: #94a3b8;
}

.list-info-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-info p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 400px;
}

.badge-new {
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    padding: 3px 10px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 700;
    box-shadow: 0 4px 10px rgba(244, 63, 94, 0.3);
}

.chat-delete {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    color: #94a3b8;
    text-decoration: none;
    border-radius: 12px;
    transition: 0.3s;
    font-size: 20px;
}

.chat-delete:hover {
    background: #fee2e2;
    color: #ef4444;
}

/* CHAT DETAIL */
.chat-layout {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    border-radius: 30px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.10);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 680px;
}

.chat-header-real {
    padding: 18px 25px;
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-header-real a {
    color: white;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 14px;
    border-radius: 50px;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}

.chat-header-real a:hover {
    background: rgba(255, 255, 255, 0.3);
}

.chat-header-real b {
    font-size: 17px;
    letter-spacing: -0.3px;
}

.chat-body-real {
    flex: 1;
    overflow-y: auto;
    padding: 25px;
    background: rgba(255, 255, 255, 0.5);
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.bubble {
    max-width: 65%;
    padding: 12px 18px;
    font-size: 14px;
    line-height: 1.6;
    border-radius: 20px;
    word-wrap: break-word;
}

.bubble.user {
    background: white;
    color: #1e293b;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
    border: 1px solid rgba(244, 63, 94, 0.12);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}

.bubble.admin {
    background: linear-gradient(135deg, #f43f5e, #ec4899);
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
    box-shadow: 0 6px 18px rgba(244, 63, 94, 0.25);
}

.bubble-time {
    font-size: 11px;
    text-align: right;
    margin-top: 4px;
    opacity: 0.8;
}

.chat-input-real {
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
    border-top: 1px solid rgba(244, 63, 94, 0.12);
}

.chat-input-real textarea {
    width: 100%;
    height: 80px;
    padding: 14px 18px;
    border-radius: 16px;
    border: 1.5px solid rgba(244, 63, 94, 0.18);
    background: white;
    font-family: inherit;
    font-size: 14px;
    color: #1e293b;
    outline: none;
    resize: none;
    transition: 0.3s;
}

.chat-input-real textarea:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
}

.chat-input-real button {
    width: 100%;
    margin-top: 10px;
    padding: 14px;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: white;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.28);
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.chat-input-real button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(244, 63, 94, 0.38);
}
</style>
</head>
<body>

<!-- 3D Canvas Background -->
<canvas id="bg-particles" style="pointer-events: none; position: fixed; inset: 0; width: 100vw; height: 100vh; z-index: 0;"></canvas>

<?= view('includes/sidebar_bidan'); ?>

<div class="main">
    <div class="konsultasi-bidan-container">
    <div class="topbar">
        <h1>Konsultasi & Tanya Bidan</h1>
        <p>Layanan konsultasi online langsung antara pasien dan bidan profesional</p>
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
                <div>
                    <h3><?= esc((string)($jPasien ?? 0)) ?></h3>
                    <p>Total Pasien Konsul</p>
                </div>
                <i class='bx bx-user' style="color: #f43f5e; background: rgba(244, 63, 94, 0.1);"></i>
            </div>
        </div>

        <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
            <div class="stat">
                <div>
                    <h3><?= esc((string)($jKonsul ?? 0)) ?></h3>
                    <p>Total Pesan Chat</p>
                </div>
                <i class='bx bx-chat' style="color: #8b5cf6; background: rgba(139, 92, 246, 0.1);"></i>
            </div>
        </div>

        <div class="card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
            <div class="stat">
                <div>
                    <h3><?= esc((string)($jPending ?? 0)) ?></h3>
                    <p>Belum Dibalas</p>
                </div>
                <i class='bx bx-time' style="color: #f59e0b; background: rgba(245, 158, 11, 0.1);"></i>
            </div>
        </div>
    </div>

    <?php if (empty($idPasien)): ?>
        <div class="list-full">
            <?php if (empty($chat_list)): ?>
                <div style="text-align:center; padding:50px; color:#94a3b8;">
                    Belum ada riwayat konsultasi pasien.
                </div>
            <?php else: ?>
                <?php foreach ($chat_list as $c): ?>
                    <div class="conversation-row">
                        <a href="<?= site_url('konsultasi_bidan/' . (int)$c['id_pasien']) ?>" class="list-item">
                            <img src="<?= base_url('assets/profile/' . (!empty($c['foto']) ? $c['foto'] : 'default.png')) ?>" alt="Avatar">
                            <div class="list-info">
                                <div class="list-info-top">
                                    <h3><?= esc($c['nama']) ?></h3>
                                    <small><?= !empty($c['last_time']) ? date('d M, H:i', strtotime($c['last_time'])) : '-' ?></small>
                                </div>
                                <div class="list-info-bottom">
                                    <p><?= esc($c['last_chat'] ?? 'Belum ada percakapan') ?></p>
                                    <?php if (($c['belum_dibaca'] ?? 0) > 0): ?>
                                        <span class="badge-new"><?= esc((string)$c['belum_dibaca']) ?> Pesan Baru</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                        <a href="<?= site_url('hapus_chat/' . (int)$c['id_pasien']) ?>"
                           onclick="return confirm('Hapus seluruh riwayat chat <?= esc($c['nama'], 'attr') ?>?')"
                           class="chat-delete"
                           title="Hapus Percakapan">
                            <i class='bx bx-trash'></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="chat-layout">
            <div class="chat-header-real">
                <a href="<?= site_url('konsultasi_bidan') ?>">
                    <i class='bx bx-left-arrow-alt'></i> Kembali
                </a>
                <span>|</span>
                <b><i class='bx bx-user'></i> <?= esc($pasien['nama'] ?? 'Pasien') ?></b>
            </div>

            <div class="chat-body-real" id="chatBody">
                <?php if (!empty($chat_detail)): ?>
                    <?php foreach ($chat_detail as $cd): ?>
                        <div class="bubble <?= ($cd['pengirim'] == 'user') ? 'user' : 'admin' ?>">
                            <?= nl2br(esc($cd['pesan'])) ?>
                            <div class="bubble-time">
                                <?= !empty($cd['created_at']) ? date('H:i', strtotime($cd['created_at'])) : '' ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align:center; color:#94a3b8; margin-top:30px;">
                        Belum ada pesan dalam percakapan ini.
                    </div>
                <?php endif; ?>
            </div>

            <div class="chat-input-real">
                <form action="<?= site_url('kirim_balasan') ?>" method="post">
                    <?= csrf_field() ?>
                    <textarea
                        name="balasan"
                        placeholder="Ketik balasan konsultasi medis Anda di sini..."
                        required></textarea>
                    <input type="hidden" name="id_pasien" value="<?= esc($idPasien) ?>">
                    <button type="submit">
                        <i class='bx bxs-paper-plane'></i> Kirim Balasan Bidan
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
<script>
function scrollBottom() {
    const chatBody = document.getElementById('chatBody');
    if(chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
}
window.onload = scrollBottom;
</script>
<script>
setInterval(() => {
    fetch("<?= site_url('bidan/updateLastSeen') ?>");
}, 5000);
</script>
</body>
</html>
