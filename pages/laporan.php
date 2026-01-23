<?php
include __DIR__ . '/../koneksi.php';

$tanggal_hari_ini = date('d-m-Y');

// ambil data
$data = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY id_penjualan DESC");

// hitung total
$total_transaksi = 0;
$total_pajak = 0;
$total_pendapatan = 0;

while ($row = mysqli_fetch_assoc($data)) {
    $total_transaksi++;
    $total_pajak += $row['pajak'];
    $total_pendapatan += $row['subtotal'];
}

// ulangi query buat tabel
$data = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY id_penjualan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:20px}
.container{background:#fff;padding:20px}
h2{text-align:center}
.tgl{text-align:center;margin-bottom:15px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:8px;text-align:center}
th{background:#2c3e50;color:#fff}
.summary{margin-top:15px}
button{padding:8px 15px;background:#27ae60;color:#fff;border:none;cursor:pointer}

@media print{
    button{display:none}
    body{background:#fff}
}
</style>
</head>

<body>

<div class="container">
<h2>LAPORAN PENJUALAN</h2>
<p class="tgl">Tanggal: <b><?= $tanggal_hari_ini ?></b></p>

<table>
<tr>
<th>No</th>
<th>Kode Penjualan</th>
<th>Nama Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Pajak</th>
<th>Subtotal</th>
</tr>

<?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $row['kode_penjualan'] ?></td>
<td><?= $row['nama_produk'] ?></td>
<td><?= number_format($row['harga']) ?></td>
<td><?= $row['qty'] ?></td>
<td><?= number_format($row['pajak']) ?></td>
<td><?= number_format($row['subtotal']) ?></td>
</tr>
<?php } ?>
</table>

<div class="summary">
<p><b>Jumlah Transaksi :</b> <?= $total_transaksi ?></p>
<p><b>Total Pajak :</b> Rp <?= number_format($total_pajak) ?></p>
<p><b>Total Pendapatan :</b> Rp <?= number_format($total_pendapatan) ?></p>
</div>

<br>
<button onclick="window.print()">Cetak Laporan</button>
</div>

</body>
</html>
