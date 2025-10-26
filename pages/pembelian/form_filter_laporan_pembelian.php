<?php
include("../../config/database.php");
include("../../layouts/header.php");
include("../../layouts/sidebar_admin.php");

$id = $_GET['id'];

// ambil header pembelian
$header = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kasir_app_pembelian WHERE pembelian_id='$id'"));

// ambil detail barang
$detail = mysqli_query($conn, "SELECT b.nama_barang, d.jumlah, d.harga_beli, d.subtotal
                               FROM kasir_app_detail_pembelian d
                               JOIN kasir_app_barang b ON d.barang_id=b.barang_id
                               WHERE d.pembelian_id='$id'");
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Detail Pembelian #<?= $id ?></h1>
<p>Tanggal: <?= $header['tanggal'] ?></p>
<p>Total Harga: <?= number_format($header['total_harga'],0,",",".") ?></p>

<table class="w-full border mt-4">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 border">Nama Barang</th>
            <th class="p-2 border">Harga Beli</th>
            <th class="p-2 border">Jumlah</th>
            <th class="p-2 border">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($detail)) : ?>
        <tr>
            <td class="p-2 border"><?= $row['nama_barang'] ?></td>
            <td class="p-2 border"><?= number_format($row['harga_beli'],0,",",".") ?></td>
            <td class="p-2 border"><?= $row['jumlah'] ?></td>
            <td class="p-2 border"><?= number_format($row['subtotal'],0,",",".") ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="index.php" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">Kembali</a>

<?php include("../../layouts/footer.php"); ?>
