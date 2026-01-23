<?php
// KONEKSI
include __DIR__ . '/../koneksi.php';
/* ================= HAPUS ================= */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    echo "<script>location='dashboard.php?page=customers';</script>";
}

/* ================= AMBIL DATA EDIT ================= */
$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $q  = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
    $edit = mysqli_fetch_assoc($q);
}

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {
    mysqli_query($conn, "
        UPDATE pelanggan SET
            kode_pelanggan='$_POST[kode_pelanggan]',
            nama_pelanggan='$_POST[nama_pelanggan]',
            alamat='$_POST[alamat]',
            no_hp='$_POST[no_hp]',
            email='$_POST[email]'
        WHERE id_pelanggan='$_POST[id_pelanggan]'
    ");
    echo "<script>location='dashboard.php?page=customers';</script>";
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
    echo "<script>location='dashboard.php?page=customers';</script>";
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
a{margin-right:5px;text-decoration:none}
a.hapus{color:red}
a.edit{color:blue}
</style>
</head>

<body>

<h3><?= $edit ? 'Edit Customer' : 'Tambah Customer' ?></h3>
<form method="POST">
<?php if ($edit) { ?>
    <input type="hidden" name="id_pelanggan" value="<?= $edit['id_pelanggan'] ?>">
<?php } ?>

<input type="text" name="kode_pelanggan" placeholder="Kode Pelanggan"
value="<?= $edit['kode_pelanggan'] ?? '' ?>">

<input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" required
value="<?= $edit['nama_pelanggan'] ?? '' ?>">

<textarea name="alamat" placeholder="Alamat"><?= $edit['alamat'] ?? '' ?></textarea>

<input type="text" name="no_hp" placeholder="No HP"
value="<?= $edit['no_hp'] ?? '' ?>">

<input type="email" name="email" placeholder="Email"
value="<?= $edit['email'] ?? '' ?>">

<button name="<?= $edit ? 'update' : 'simpan' ?>">
<?= $edit ? 'Update' : 'Simpan' ?>
</button>
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
    <a class="edit"
       href="dashboard.php?page=customers&edit=<?= $row['id_pelanggan'] ?>">
       Edit
    </a>
    |
    <a class="hapus"
       href="dashboard.php?page=customers&hapus=<?= $row['id_pelanggan'] ?>"
       onclick="return confirm('Yakin hapus data ini?')">
       Hapus
    </a>
</td>
</tr>
<?php } ?>
</table>

</body>
</html>
