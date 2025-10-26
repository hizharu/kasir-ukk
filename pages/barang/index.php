<?php
include "../../config/auth.php";
include "../../config/database.php";
include "../../layouts/header.php";
include "../../layouts/sidebar_admin.php";

// ambil semua data barang
$barang = mysqli_query($conn, "SELECT * FROM kasir_app_barang ORDER BY barang_id DESC");
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Manajemen Barang</h1>

<a href="create.php" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
  + Tambah Barang
</a>

<div class="bg-white shadow rounded-lg overflow-hidden">
  <table class="w-full text-left border-collapse">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-3">Nama Barang</th>
        <th class="p-3">Kategori</th>
        <th class="p-3">Harga Beli</th>
        <th class="p-3">Harga Jual</th>
        <th class="p-3">Stok</th>
        <th class="p-3">Satuan</th>
        <th class="p-3 text-center">Aksi</th>
      </tr>
    </thead>

    <tbody>
      <?php while($row = mysqli_fetch_assoc($barang)): ?>
      <tr class="border-b">
        <td class="p-3"><?php echo $row['nama_barang']; ?></td>
        <td class="p-3"><?php echo $row['kategori']; ?></td>
        <td class="p-3">Rp <?php echo number_format($row['harga_beli']); ?></td>
        <td class="p-3">Rp <?php echo number_format($row['harga_jual']); ?></td>
        <td class="p-3"><?php echo $row['stok']; ?></td>
        <td class="p-3"><?php echo $row['satuan']; ?></td>
        <td class="p-3 text-center">
          <a href="edit.php?id=<?php echo $row['barang_id']; ?>" class="text-blue-600 hover:underline">Edit</a> |
          <a href="delete.php?id=<?php echo $row['barang_id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include "../../layouts/footer.php"; ?>
