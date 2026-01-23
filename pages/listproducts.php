<?php
session_start();
include __DIR__ . '/../koneksi.php';

/* PROSES HAPUS */
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']); // aman dari SQL Injection
    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id'");
    if ($hapus) {
        $_SESSION['success'] = "Produk berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus produk!";
    }
    header("Location: dashboard.php?page=listproducts");
    exit;
}

/* AMBIL DATA */
$data = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang DESC");
?>

<style>
.card {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.card-header h3 {
    margin: 0;
    color: #1f2d3d;
}

.btn {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    cursor: pointer;
}

.btn-tambah { background: #1e3799; }
.btn-edit   { background: #0a3d62; }
.btn-hapus  { background: #c0392b; }

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    font-size: 13px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

th {
    background: #f5f7fa;
    font-weight: bold;
}

td.aksi {
    display: flex;
    justify-content: center;
    gap: 6px;
}

/* Notifikasi */
.alert {
    padding: 10px 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    color: #fff;
}
.alert-success { background: #27ae60; }
.alert-error   { background: #e74c3c; }
</style>

<div class="card">

    <div class="card-header">
        <h3>List Produk</h3>
        <a href="dashboard.php?page=tambah" class="btn btn-tambah">
            + Tambah Produk
        </a>
    </div>

    <!-- Notifikasi -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php $no=1; while ($r = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['kode_barang']) ?></td>
                <td><?= htmlspecialchars($r['nama_barang']) ?></td>
                <td><?= htmlspecialchars($r['kategori']) ?></td>
                <td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
                <td><?= htmlspecialchars($r['stok']) ?></td>
                <td><?= htmlspecialchars($r['satuan']) ?></td>
                <td class="aksi">
                    <a href="dashboard.php?page=edit&id=<?= $r['id_barang'] ?>" class="btn btn-edit">
                        Edit
                    </a>
                    <a href="dashboard.php?page=listproducts&hapus=<?= $r['id_barang'] ?>"
                       class="btn btn-hapus"
                       onclick="return confirm('Yakin hapus produk ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">Data produk masih kosong</td>
            </tr>
        <?php endif; ?>
    </table>

</div>
