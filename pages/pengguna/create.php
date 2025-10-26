<?php
include "../../config/auth.php";
include "../../layouts/header.php";
include "../../layouts/sidebar_admin.php";
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Pengguna</h1>

<form action="../../process/user_store.php" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Nama Lengkap</label>
    <input type="text" name="nama_lengkap" required class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Username</label>
    <input type="text" name="username" required class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Password</label>
    <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
  </div>

  <div class="mb-4">
    <label class="block mb-1 text-gray-700">Role</label>
    <select name="level" class="w-full border px-3 py-2 rounded">
      <option value="administrator">Administrator</option>
      <option value="petugas">Kasir</option>
    </select>
  </div>

  <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Simpan
  </button>
</form>

<?php include "../../layouts/footer.php"; ?>
