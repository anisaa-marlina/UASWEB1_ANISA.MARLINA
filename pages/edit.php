<?php
include __DIR__ . '/../koneksi.php';

$id = intval($_GET['id']); // amanin ID
$data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$r = mysqli_fetch_assoc($data);

if(!$r){
    echo "<p>Produk tidak ditemukan!</p>";
    exit;
}

if (isset($_POST['update'])) {
    $stok = intval($_POST['stok']); // pastikan stok angka

    mysqli_query($conn, "UPDATE barang SET stok='$stok' WHERE id_barang='$id'");
    header("Location: dashboard.php?page=listproducts"); // redirect ke list produk
    exit;
}
?>

<style>
.card {
    max-width: 400px;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,.1);
}
input, button {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
}
button {
    background: #0a3d62;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background: #082a4c;
}
label {
    font-weight: bold;
    font-size: 13px;
}
</style>

<div class="card">
<h3>Edit Stok Produk</h3>

<form method="post">
    <label>Nama Produk</label>
    <input type="text" value="<?= htmlspecialchars($r['nama_barang']) ?>" readonly>

    <label>Stok</label>
    <input type="number" name="stok" value="<?= $r['stok'] ?>" required>

    <button type="submit" name="update">Update Stok</button>
</form>
</div>
