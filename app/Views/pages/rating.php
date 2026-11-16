<?php
$id_kunjungan = isset($id_kunjungan) ? $id_kunjungan : service('request')->getGet('id');

if (empty($id_kunjungan)) {
    die("ID Kunjungan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beri Ulasan & Testimoni - Bunanur Medical</title>

<!-- Master Glassmorphism 3D CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/glassmorphism-3d.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
* { margin:0; padding:0; box-sizing:border-box; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: linear-gradient(135deg, #fff5f7 0%, #fdf2f8 50%, #fce7f3 100%);
    color: #1e293b;
    min-height: 100vh;
    display: flex;
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
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    box-sizing: border-box;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

@media(max-width: 992px) {
    .main { margin-left: 85px; width: calc(100% - 85px); padding: 24px 20px; padding-top: 24px !important; }
}

@media(max-width: 576px) {
    .main { margin-left: 0; width: 100%; padding: 20px 14px; padding-top: 20px !important; }
}

.rating-card {
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    width: 100%;
    max-width: 580px;
    padding: 40px;
    border-radius: 30px;
    box-shadow: 0 20px 45px -10px rgba(244, 63, 94, 0.12);
}

.rating-header {
    text-align: center;
    margin-bottom: 28px;
}

.rating-header h2 {
    font-size: 26px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 6px;
}

.rating-header p {
    font-size: 13px;
    color: #64748b;
}

.kunjungan-badge {
    display: inline-block;
    margin-top: 8px;
    background: rgba(244, 63, 94, 0.10);
    color: #f43f5e;
    font-weight: 700;
    font-size: 12px;
    padding: 4px 14px;
    border-radius: 50px;
}

.form-group {
    margin-bottom: 22px;
}

label {
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    display: block;
    margin-bottom: 8px;
}

textarea {
    width: 100%;
    padding: 14px 18px;
    border-radius: 16px;
    border: 1.5px solid rgba(244, 63, 94, 0.16);
    background: rgba(255, 255, 255, 0.9);
    font-family: inherit;
    font-size: 14px;
    color: #1e293b;
    resize: none;
    outline: none;
    transition: 0.3s;
}

textarea:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
    background: white;
}

.stars-wrap {
    text-align: center;
    margin: 15px 0 25px;
}

.stars {
    display: inline-flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 8px;
}

.stars input {
    display: none;
}

.stars label {
    font-size: 38px;
    color: #cbd5e1;
    cursor: pointer;
    transition: all 0.25s ease;
    margin-bottom: 0;
}

.stars input:checked ~ label,
.stars label:hover,
.stars label:hover ~ label {
    color: #f59e0b;
    text-shadow: 0 0 15px rgba(245, 158, 11, 0.45);
    transform: scale(1.1);
}

.file-upload-box {
    border: 2px dashed rgba(244, 63, 94, 0.25);
    background: rgba(244, 63, 94, 0.03);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}

.file-upload-box:hover {
    border-color: #f43f5e;
    background: rgba(244, 63, 94, 0.06);
}

.file-upload-box i {
    font-size: 32px;
    color: #f43f5e;
}

.file-upload-box p {
    font-size: 13px;
    color: #64748b;
    margin-top: 6px;
    font-weight: 500;
}

.btn-submit {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 16px;
    background: linear-gradient(135deg, #f43f5e 0%, #ec4899 100%);
    color: white;
    font-size: 15px;
    font-weight: 700;
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
<canvas id="cyberCanvas"></canvas>

<?= view('includes/sidebar') ?>

<div class="main">

    <div class="rating-card" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.15">
        <div class="rating-header">
            <h2>Beri Ulasan Pasien</h2>
            <p>Pengalaman Anda sangat berharga bagi peningkatan mutu layanan kami.</p>
            <div class="kunjungan-badge">ID Kunjungan: #<?= esc($id_kunjungan) ?></div>
        </div>

        <form action="<?= site_url('simpan-rating') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="kunjungan_id" value="<?= esc($id_kunjungan) ?>">

            <div class="form-group stars-wrap">
                <label>Beri Nilai Pelayanan Kami</label>
                <div class="stars">
                    <input type="radio" name="rating" value="5" id="s5">
                    <label for="s5" class="bx bxs-star"></label>

                    <input type="radio" name="rating" value="4" id="s4">
                    <label for="s4" class="bx bxs-star"></label>

                    <input type="radio" name="rating" value="3" id="s3">
                    <label for="s3" class="bx bxs-star"></label>

                    <input type="radio" name="rating" value="2" id="s2">
                    <label for="s2" class="bx bxs-star"></label>

                    <input type="radio" name="rating" value="1" id="s1" required>
                    <label for="s1" class="bx bxs-star"></label>
                </div>
            </div>

            <div class="form-group">
                <label>Ulasan & Masukan Anda</label>
                <textarea
                    name="ulasan"
                    rows="4"
                    placeholder="Ceritakan kepuasan Anda terhadap pelayanan dan kenyamanan di klinik kami..."
                    required></textarea>
            </div>

            <div class="form-group">
                <label>Bukti Foto (Opsional)</label>
                <div class="file-upload-box" onclick="document.getElementById('fotoInput').click()">
                    <i class='bx bx-cloud-upload'></i>
                    <p id="fileName">Klik untuk unggah foto testimoni Anda</p>
                    <input type="file" name="foto" id="fotoInput" hidden accept="image/*" onchange="document.getElementById('fileName').innerText = this.files[0].name">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class='bx bx-paper-plane'></i> Kirim Ulasan Medis
            </button>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.0/dist/vanilla-tilt.min.js"></script>
<script src="<?= base_url('assets/js/cyber-canvas-3d.js') ?>"></script>
</body>
</html>
