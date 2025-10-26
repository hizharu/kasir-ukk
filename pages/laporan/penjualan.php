<?php
include("../../config/database.php");
include("../../layouts/header.php");
$role = $_SESSION['level'] ?? 'petugas';
if($role === 'administrator'){
    include("../../layouts/sidebar_admin.php");
} else {
    include("../../layouts/sidebar_petugas.php");
}

// filter tanggal
$tanggal_awal = $_POST['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_POST['tanggal_akhir'] ?? date('Y-m-d');
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Laporan Penjualan</h1>

<form method="POST" class="mb-4 flex gap-4">
    <div>
        <label>Tanggal Awal</label>
        <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" class="border p-2 rounded">
    </div>
    <div>
        <label>Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" class="border p-2 rounded">
    </div>
    <div class="flex items-end">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </div>
</form>

<?php
// ambil data penjualan sesuai filter
$query = "SELECT * FROM kasir_app_penjualan 
          WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<table class="w-full border mt-4">
    <thead>
        <tr class="bg-gray-100">
            <th class="p-2 border">ID Penjualan</th>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Total Harga</th>
            <th class="p-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td class="p-2 border"><?= $row['penjualan_id'] ?></td>
            <td class="p-2 border"><?= $row['tanggal'] ?></td>
            <td class="p-2 border"><?= number_format($row['total_harga'],0,",",".") ?></td>
            <td class="p-2 border text-center">
                <a href="penjualan_detail.php?id=<?= $row['penjualan_id'] ?>" class="bg-green-600 text-white px-2 py-1 rounded">Detail</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include("../../layouts/footer.php"); ?>
