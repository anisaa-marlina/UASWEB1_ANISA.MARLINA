<?php
// KONEKSI
include __DIR__ . '/../koneksi.php';


/* ================= HAPUS ================= */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    echo "<script>window.location='dashboard.php?page=customers';</script>";
}

/* ================= TAMBAH ================= */
if (isset($_POST['simpan'])) {
    mysqli_query($conn, "
        INSERT INTO pelanggan
        (kode_pelanggan, nama_pelanggan, alamat, no_hp, email)
        VALUES (
            '$_POST[kode_pelanggan]',
            '$_POST[nama_pelanggan]',
            '$_POST[alamat]',
            '$_POST[no_hp]',
            '$_POST[email]'
        )
    ");
    echo "<script>window.location='dashboard.php?page=customers';</script>";
}

// AMBIL DATA
$data = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Customers</title>
<style>
body{font-family:Arial;background:#f5f5f5;padding:20px}
h3{margin-top:0}
table{width:100%;border-collapse:collapse;background:#fff}
th,td{border:1px solid #ddd;padding:8px}
th{background:#2c3e50;color:#fff}
form{background:#fff;padding:15px;margin-bottom:15px}
input,textarea{width:100%;padding:7px;margin:5px 0}
button{background:#27ae60;color:#fff;border:none;padding:8px 15px}
a.hapus{color:red;text-decoration:none}
</style>
</head>

<body>

<h3>Tambah Customer</h3>
<form method="POST">
<input type="text" name="kode_pelanggan" placeholder="Kode Pelanggan">
<input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
<textarea name="alamat" placeholder="Alamat"></textarea>
<input type="text" name="no_hp" placeholder="No HP">
<input type="email" name="email" placeholder="Email">
<button name="simpan">Simpan</button>
</form>

<h3>Data Customers</h3>
<table>
<tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Alamat</th>
<th>No HP</th>
<th>Email</th>
<th>Aksi</th>
</tr>

<?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $row['kode_pelanggan'] ?></td>
<td><?= $row['nama_pelanggan'] ?></td>
<td><?= $row['alamat'] ?></td>
<td><?= $row['no_hp'] ?></td>
<td><?= $row['email'] ?></td>
<td>
    <a class="hapus"
       href="dashboard.php?page=customers&hapus=<?= $row['id_pelanggan']; ?>"
       onclick="return confirm('Yakin hapus data ini?')">
       Hapus
    </a>
</td>
</tr>
<?php } ?>

</table>

</body>
</html>
