<?php
session_start();
include '../config/koneksi.php';

/** @var mysqli $conn */

if(!isset($_SESSION['pasien'])){
    header("Location: login_pasien.php");
    exit;
}

// ambil id aman
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0){
    echo "ID tidak valid";
    exit;
}

// ambil data layanan
$layanan = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM layanan WHERE id='$id'
"));

if(!$layanan){
    echo "Layanan tidak ditemukan";
    exit;
}

/* ================= RATING ================= */

$ratingData = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT 
    ROUND(AVG(t.rating),1) as avg_rating,
    COUNT(t.id) as total
FROM testimoni t
JOIN kunjungan k ON t.kunjungan_id = k.id
WHERE k.layanan = '$id'
AND t.approve='approve'
"));

$rata  = $ratingData['avg_rating'] ?? 0;
$count = $ratingData['total'] ?? 0;

/* ================= TESTIMONI ================= */

$testimoni = mysqli_query($conn, "
SELECT t.*, p.nama, p.foto AS foto_pasien
FROM testimoni t
JOIN pasien p ON t.pasien_id = p.id
JOIN kunjungan k ON t.kunjungan_id = k.id
WHERE k.layanan = '$id'
AND t.approve='approve'
ORDER BY t.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Layanan</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#f7dde3,#efd0d6);
margin:0;
}

/* CONTAINER */
.container{
max-width:1000px;
margin:auto;
padding:40px 20px;
}

/* CARD DETAIL */
.detail-card{
background:rgba(255,255,255,0.8);
backdrop-filter:blur(18px);
border-radius:30px;
overflow:hidden;
box-shadow:0 15px 40px rgba(0,0,0,.08);
margin-bottom:40px;
}

.detail-img{
width:100%;
height:350px;
object-fit:cover;
}

.detail-body{
padding:30px;
}

.badge{
background:#f7e6ea;
color:#b76e79;
padding:8px 16px;
border-radius:30px;
font-size:12px;
font-weight:600;
display:inline-block;
margin-bottom:15px;
}

.detail-body h2{
margin:0 0 10px;
}

.detail-body p{
color:#666;
line-height:1.7;
}

/* META */
.meta{
display:flex;
justify-content:space-between;
margin-top:20px;
font-weight:500;
color:#444;
}

/* BUTTON */
.btn-ajukan{
margin-top:25px;
width:100%;
padding:16px;
border:none;
border-radius:18px;
background:rgba(183,110,121,0.25);
backdrop-filter:blur(12px);
color:white;
font-weight:600;
cursor:pointer;
position:relative;
overflow:hidden;
transition:.3s;
}

.btn-ajukan:hover{
box-shadow:
0 0 15px rgba(183,110,121,0.7),
0 0 30px rgba(183,110,121,0.4);
transform:scale(1.03);
}

.btn-ajukan::before{
content:'';
position:absolute;
top:0;
left:-100%;
width:100%;
height:100%;
background:linear-gradient(
120deg,
transparent,
rgba(255,255,255,0.5),
transparent
);
transition:.5s;
}

.btn-ajukan:hover::before{
left:100%;
}

/* TESTIMONI */
.section-title{
font-size:22px;
margin-bottom:20px;
}

.testi-box{
background:rgba(255,255,255,0.75);
backdrop-filter:blur(12px);
padding:20px;
border-radius:20px;
margin-bottom:15px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.testi-user{
display:flex;
align-items:center;
gap:10px;
margin-bottom:10px;
}

.testi-user img{
width:40px;
height:40px;
border-radius:50%;
object-fit:cover;
}

.rating{
color:#ffb400;
margin-bottom:10px;
}

.foto-testi{
width:100%;
border-radius:12px;
margin-top:10px;
cursor:pointer;
transition:.3s;
}

.foto-testi:hover{
transform:scale(1.02);
}

.rating-summary{
display:flex;
align-items:center;
gap:10px;
margin-bottom:15px;
}
</style>
    <link rel="stylesheet" href="<?= base_url('assets/css/responsive-mobile.css') ?>">
</head>

<body>

<div class="container">

<!-- DETAIL -->
<div class="detail-card">

<img 
src="<?= base_url('assets/layanan/' . (!empty($layanan['gambar']) ? $layanan['gambar'] : 'default.png')) ?>" 
class="detail-img"
onerror="this.src='<?= base_url('assets/layanan/default.png') ?>'"
>

<div class="detail-body">

<div class="badge"><?= $layanan['kategori'] ?></div>

<h2><?= $layanan['nama_layanan'] ?></h2>

<div class="rating-summary">
    <div style="color:#ffb400;font-size:18px;">
        <?php 
        $r = round($rata,1);
        for($i=1;$i<=5;$i++){
            echo $i <= $r ? '⭐' : '☆';
        }
        ?>
    </div>

    <span style="color:#555;font-size:14px;">
        <?= $r ?>/5 (<?= $count ?> review)
    </span>
</div>

<p><?= $layanan['deskripsi'] ?></p>

<div class="meta">
<span>Rp<?= number_format($layanan['harga']) ?></span>
<span><?= $layanan['durasi'] ?></span>
</div>

<div style="margin-top:30px;text-align:center;">
    <button 
    class="btn-ajukan"
    onclick="window.location='ajukan_kunjungan.php?id=<?= $layanan['id'] ?>'">
    Ajukan Layanan
    </button>
</div>

</div>
</div>


<!-- TESTIMONI -->
<h3 class="section-title">Testimoni Pasien</h3>

<?php if(mysqli_num_rows($testimoni) == 0): ?>
<p>Belum ada testimoni</p>
<?php endif; ?>

<?php while($t = mysqli_fetch_assoc($testimoni)): ?>

<div class="testi-box">

<div class="testi-user">
<img src="<?= base_url('assets/profile/' . esc($t['foto_pasien'] ?: 'default.png', 'attr')) ?>">
<strong><?= esc($t['nama']) ?></strong>
</div>

<div class="rating">
<?php for($i=1; $i<=5; $i++): ?>
<?= $i <= (int)$t['rating'] ? '⭐' : '☆' ?>
<?php endfor; ?>
</div>

<p><?= esc($t['ulasan'], 'html') ?></p>

<?php if(!empty($t['foto'])): ?>
<img 
src="<?= base_url('assets/testimoni/' . esc($t['foto'], 'attr')) ?>" 
class="foto-testi"
onclick="window.open(this.src)">
<?php endif; ?>

</div>

<?php endwhile; ?>

</div>


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