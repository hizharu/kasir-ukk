<?php
include "../../config/auth.php";
include "../../layouts/header.php";
include "../../layouts/sidebar_admin.php";
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Barang</h1>

<form action="../../process/barang_store.php" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Nama Barang</label>
    <input type="text" name="nama_barang" required class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Kategori</label>
    <input type="text" name="kategori" class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4 grid grid-cols-2 gap-4">
    <div>
      <label class="block mb-1 text-gray-700">Harga Beli</label>
      <input type="number" name="harga_beli" required class="w-full border px-3 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1 text-gray-700">Harga Jual</label>
      <input type="number" name="harga_jual" required class="w-full border px-3 py-2 rounded">
    </div>
  </div>

  <div class="mb-4 grid grid-cols-2 gap-4">
    <div>
      <label class="block mb-1 text-gray-700">Stok Awal</label>
      <input type="number" name="stok" required class="w-full border px-3 py-2 rounded">
    </div>
    <div>
      <label class="block mb-1 text-gray-700">Satuan</label>
      <input type="text" name="satuan" class="w-full border px-3 py-2 rounded">
    </div>
  </div>

  <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Simpan
  </button>
</form>

<?php include "../../layouts/footer.php"; ?>
