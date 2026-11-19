<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../config/koneksi.php';

/** @var mysqli $conn */

if(!isset($_SESSION['bidan'])){
    header("Location: login_bidan.php");
    exit;
}

/* =========================
   AMBIL ID PASIEN
========================= */
$id_pasien = isset($_GET['id_pasien']) ? (int)$_GET['id_pasien'] : 0;

if($id_pasien == 0){
    echo "<div style='margin:auto;color:#999'>Pilih chat pasien</div>";
    exit;
}

/* =========================
   KIRIM PESAN
========================= */
if(isset($_POST['kirim'])){
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    mysqli_query($conn,"
    INSERT INTO chat (id_pasien,pesan,pengirim,status,status_baca)
    VALUES ('$id_pasien','$pesan','bidan','dibalas','dibaca')
    ");

    header("Location: konsultasi_bidan.php?id_pasien=".$id_pasien);
    exit;
}

/* =========================
   DATA PASIEN
========================= */
$pasien = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pasien WHERE id=$id_pasien
"));

/* =========================
   AMBIL CHAT
========================= */
$chat = mysqli_query($conn,"
SELECT * FROM chat
WHERE id_pasien=$id_pasien
ORDER BY id ASC
");

/* =========================
   AUTO DIBACA
========================= */
mysqli_query($conn,"
UPDATE chat
SET status_baca='dibaca'
WHERE id_pasien=$id_pasien
AND pengirim='user'
AND status_baca='terkirim'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Chat</title>

<style>
/* HEADER */
.chat-header{
display:flex;
align-items:center;
gap:10px;
padding:12px;
background:#f3e4e8;
border-bottom:1px solid #ddd;
}

.chat-header img{
width:40px;
height:40px;
border-radius:50%;
object-fit:cover;
}

/* WRAPPER */
.chat-wrapper{
height:100%;
display:flex;
flex-direction:column;
background:#fdf2f5;
}

/* BODY */
.chat-body{
flex:1;
overflow-y:auto;
padding:20px;
display:flex;
flex-direction:column;
}

/* BUBBLE UMUM */
.bubble{
padding:12px 16px;
margin:6px 0;
border-radius:16px;
max-width:60%;
font-size:13px;
display:flex;
flex-direction:column;
}

/* PASIEN (KIRI) */
.user{
background:white;
align-self:flex-start;
border-bottom-left-radius:5px;
}

/* BIDAN (KANAN) */
.admin{
background:#f8cdd6;
align-self:flex-end;
border-bottom-right-radius:5px;
}

/* META */
.meta{
display:flex;
justify-content:flex-end;
gap:5px;
margin-top:4px;
font-size:11px;
}

.time{ color:#999; }
.gray{ color:#999; }
.blue{ color:#34b7f1; }

/* INPUT */
.chat-input{
padding:15px;
background:transparent;
}

.chat-input form{
display:flex;
gap:10px;
}

.chat-input textarea{
flex:1;
height:45px;
border-radius:20px;
border:1px solid #ddd;
padding:10px 15px;
resize:none;
outline:none;
}

.chat-input button{
background:#b76e79;
border:none;
color:white;
padding:10px 18px;
border-radius:20px;
cursor:pointer;
}

.chat-input button:hover{
background:#a25f6a;
}

/* BACK */
.back-btn{
text-decoration:none;
font-size:20px;
margin-right:10px;
color:#555;
}
</style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="chat-header">

<a href="konsultasi_bidan.php" class="back-btn">
    ←
</a>

<img src="<?= base_url('assets/profile/' . (!empty($pasien['foto']) ? esc($pasien['foto'], 'attr') : 'default.png')) ?>">

<div>
<b><?= esc($pasien['nama'] ?? '') ?></b><br>
<small style="color:#b76e79;">● Online</small>
</div>

</div>

<!-- ================= CHAT ================= -->
<div class="chat-wrapper">

    <!-- ================= CHAT ================= -->
    <div class="chat-body" id="chatBody">

    <?php if(mysqli_num_rows($chat)==0): ?>

    <div style="text-align:center;color:#999;margin-top:20px;">
    Belum ada chat
    </div>

    <?php else: ?>

    <?php while($c=mysqli_fetch_assoc($chat)): ?>

<?php if($c['pengirim']=='user'): ?>

<!-- PASIEN (KIRI) -->
<div class="bubble user">
    <?= nl2br(esc($c['pesan'])) ?>

    <div class="meta">
        <span class="time"><?= date('H:i', strtotime($c['created_at'])) ?></span>
    </div>
</div>

<?php else: ?>

<!-- BIDAN (KANAN) -->
<div class="bubble admin">
    <?= nl2br(esc($c['pesan'])) ?>

    <div class="meta">
        <span class="time"><?= date('H:i', strtotime($c['created_at'])) ?></span>

        <span class="status">
            <?php if($c['status_baca']=='terkirim'): ?>
                <span class="gray">✔</span>
            <?php elseif($c['status_baca']=='dibaca'): ?>
                <span class="blue">✔✔</span>
            <?php endif; ?>
        </span>
    </div>
</div>

<?php endif; ?>>

    <?php endwhile; ?>

    <?php endif; ?>

    </div>

    <!-- ================= INPUT ================= -->
    <div class="chat-input">

    <form method="POST">
    <?= csrf_field() ?>

    <textarea name="pesan" placeholder="Ketik pesan..." required></textarea>

    <button type="submit" name="kirim">Kirim</button>

    </form>

    </div>

</div>

<script>
// AUTO SCROLL KE BAWAH
let chatBody = document.getElementById("chatBody");
if(chatBody){
    chatBody.scrollTop = chatBody.scrollHeight;
}
</script>
<script>
setInterval(function(){
    fetch('update_last_seen.php');
}, 5000);
</script>
</body>
</html>