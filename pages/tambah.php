<?php
include __DIR__ . '/../koneksi.php';

// Daftar produk
$produk = [
    "AT001" => ["nama"=>"Pensil", "kategori"=>"Alat Tulis", "harga"=>2000, "satuan"=>"pcs"],
    "AT002" => ["nama"=>"Pulpen", "kategori"=>"Alat Tulis", "harga"=>3000, "satuan"=>"pcs"],
    "AT003" => ["nama"=>"Buku Tulis", "kategori"=>"Alat Tulis", "harga"=>5000, "satuan"=>"pcs"],
    "MK001" => ["nama"=>"Indomie", "kategori"=>"Makanan", "harga"=>3500, "satuan"=>"bungkus"],
    "MK002" => ["nama"=>"Biskuit", "kategori"=>"Makanan", "harga"=>4000, "satuan"=>"bungkus"],
    "MN001" => ["nama"=>"Aqua", "kategori"=>"Minuman", "harga"=>3000, "satuan"=>"botol"],
    "MN002" => ["nama"=>"Teh Botol", "kategori"=>"Minuman", "harga"=>4500, "satuan"=>"botol"],
    "MN003" => ["nama"=>"Kopi", "kategori"=>"Minuman", "harga"=>5000, "satuan"=>"sachet"],
    "MN004" => ["nama"=>"Susu", "kategori"=>"Minuman", "harga"=>6000, "satuan"=>"kotak"],
    "MN005" => ["nama"=>"Energen", "kategori"=>"Minuman", "harga"=>3000, "satuan"=>"sachet"]
];

// Jika tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $kode = $_POST['kode'];

    if(isset($produk[$kode])){
        $p = $produk[$kode];
        $stok = 1; // stok default

        mysqli_query($conn, "
            INSERT INTO barang
            (kode_barang, nama_barang, kategori, harga, stok, satuan)
            VALUES
            ('$kode', '{$p['nama']}', '{$p['kategori']}', '{$p['harga']}', '$stok', '{$p['satuan']}')
        ");

        // Redirect ke list products
        header("Location: dashboard.php?page=listproducts");
        exit;
    } else {
        echo "Produk tidak ditemukan!";
    }
}
?>

<style>
.card {
    max-width: 450px;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,.1);
}
label { font-weight: bold; font-size: 13px; }
select, button {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
}
button {
    background: #1e3799;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover { background: #162c81; }
</style>

<div class="card">
<h3>Tambah Produk</h3>

<form method="post">
    <label>Pilih Produk</label>
    <select name="kode" required>
        <option value="">-- Pilih Produk --</option>
        <?php foreach ($produk as $k => $v): ?>
            <option value="<?= $k ?>">
                <?= $v['nama'] ?> (<?= $v['kategori'] ?>)
            </option>
        <?php endforeach ?>
    </select>

    <button type="submit" name="simpan">Simpan Produk</button>
</form>
</div>
