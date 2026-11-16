<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Kunjungan Pasien</title>

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#333;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
    color:#865c65;
}

.subtitle{
    font-size:13px;
    margin-top:5px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th{
    background:#b07a84;
    color:#fff;
    border:1px solid #ddd;
    padding:8px;
    text-align:center;
}

table td{
    border:1px solid #ddd;
    padding:6px;
    font-size:11px;
}

.status{
    text-transform:uppercase;
    font-weight:bold;
}

.footer{
    margin-top:20px;
    text-align:right;
    font-size:11px;
}

</style>
</head>

<body>

<div class="header">
    <h2>BUNANUR MOTHER CARE CLINIC</h2>
    <div class="subtitle">
        Laporan Kunjungan Pasien
    </div>
</div>

<table>

<thead>
<tr>
    <th>No</th>
    <th>Pasien</th>
    <th>Usia</th>
    <th>Wali</th>
    <th>Alamat</th>
    <th>Layanan</th>
    <th>Tanggal</th>
    <th>Jam</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

<?php $no = 1; ?>

<?php if (!empty($kunjungan)) : ?>
    
    <?php foreach ($kunjungan as $k) : ?>

    <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($k['nama_pasien']) ?></td>
        <td><?= esc($k['usia']) ?></td>
        <td><?= esc($k['nama_ortu']) ?></td>
        <td><?= esc($k['alamat']) ?></td>
        <td><?= esc($k['nama_layanan'] ?? '-') ?></td>
        <td><?= date('d-m-Y', strtotime($k['tanggal'])) ?></td>
        <td><?= $k['jam'] ?></td>
        <td class="status"><?= strtoupper($k['status']) ?></td>
    </tr>

    <?php endforeach; ?>

<?php else : ?>

    <tr>
        <td colspan="9" style="text-align:center;">
            Tidak ada data kunjungan
        </td>
    </tr>

<?php endif; ?>

</tbody>

</table>

<div class="footer">
    Dicetak pada :
    <?= date('d-m-Y H:i') ?>
</div>

</body>
</html>