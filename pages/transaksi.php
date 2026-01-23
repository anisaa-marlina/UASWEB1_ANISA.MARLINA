<?php
include __DIR__ . '/../koneksi.php';
/* ================= SIMPAN ================= */
if (isset($_POST['simpan'])) {
    $kode   = $_POST['kode_penjualan'];
    $produk = $_POST['nama_produk'];
    $harga  = $_POST['harga'];
    $qty    = $_POST['qty'];

    $total = $harga * $qty;

    // PAJAK OTOMATIS
    if ($total < 50000) {
        $pajak = $total * 0.05; // 5%
    } else {
        $pajak = $total * 0.10; // 10%
    }

    $subtotal = $total + $pajak;

    mysqli_query($conn, "
        INSERT INTO penjualan
        (kode_penjualan, nama_produk, harga, qty, pajak, subtotal)
        VALUES
        ('$kode','$produk','$harga','$qty','$pajak','$subtotal')
    ");

    echo "<script>location='dashboard.php?page=transaksi';</script>";
}

/* ================= HAPUS ================= */
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan='$_GET[hapus]'");
    echo "<script>location='dashboard.php?page=transaksi';</script>";
}

/* ================= UPDATE QTY ================= */
if (isset($_POST['update'])) {
    $id    = $_POST['id'];
    $qty   = $_POST['qty'];
    $harga = $_POST['harga'];

    $total = $harga * $qty;

    if ($total < 50000) {
        $pajak = $total * 0.05;
    } else {
        $pajak = $total * 0.10;
    }

    $subtotal = $total + $pajak;

    mysqli_query($conn, "
        UPDATE penjualan
        SET qty='$qty', pajak='$pajak', subtotal='$subtotal'
        WHERE id_penjualan='$id'
    ");

    echo "<script>location='dashboard.php?page=transaksi';</script>";
}

/* ================= AMBIL DATA ================= */
$data = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY id_penjualan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Transaksi Penjualan</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:20px}
form{background:#fff;padding:15px;margin-bottom:15px}
input{padding:6px}
button{background:#3498db;color:#fff;border:none;padding:6px 10px}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{border:1px solid #ddd;padding:8px;text-align:center}
th{background:#2c3e50;color:#fff}
a.hapus{color:red;text-decoration:none}
</style>
</head>

<body>

<h3>Transaksi Penjualan</h3>

<form method="POST">
<input type="text" name="kode_penjualan" placeholder="Kode Penjualan (PJ001)" required>
<input type="text" name="nama_produk" placeholder="Nama Produk" required>
<input type="number" name="harga" placeholder="Harga" required>
<input type="number" name="qty" placeholder="Qty" required>
<button name="simpan">Simpan</button>
</form>

<table>
<tr>
<th>No</th>
<th>Kode</th>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Pajak</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $row['kode_penjualan'] ?></td>
<td><?= $row['nama_produk'] ?></td>
<td><?= number_format($row['harga']) ?></td>

<td>
<form method="POST" style="display:flex;gap:5px;justify-content:center">
<input type="hidden" name="id" value="<?= $row['id_penjualan'] ?>">
<input type="hidden" name="harga" value="<?= $row['harga'] ?>">
<input type="number" name="qty" value="<?= $row['qty'] ?>" style="width:60px">
<button name="update">Edit</button>
</form>
</td>

<td><?= number_format($row['pajak']) ?></td>
<td><?= number_format($row['subtotal']) ?></td>
<td>
<a class="hapus"
   href="dashboard.php?page=transaksi&hapus=<?= $row['id_penjualan'] ?>"
   onclick="return confirm('Yakin hapus data?')">
   Hapus
</a>
</td>
</tr>
<?php } ?>

</table>

</body>
</html>
