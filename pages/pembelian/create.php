<?php
include "../../config/auth.php";
include "../../layouts/header.php";
include "../../layouts/sidebar_admin.php";
include "../../config/database.php";

// Ambil data barang untuk dropdown
$barang = mysqli_query($conn, "SELECT * FROM kasir_app_barang ORDER BY nama_barang ASC");
?>

<h1 class="text-2xl font-semibold text-gray-700 mb-6">Tambah Pembelian Barang</h1>

<form action="../../process/pembelian_store.php" method="POST">
  <div class="bg-white p-6 rounded shadow max-w-4xl">

    <div class="mb-4">
      <label class="block text-gray-700 mb-1">Tanggal Pembelian</label>
      <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="border px-3 py-2 rounded">
    </div>

    <table class="w-full text-left border mb-4" id="tabel-barang">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2 border">Barang</th>
          <th class="p-2 border">Harga Beli</th>
          <th class="p-2 border">Jumlah</th>
          <th class="p-2 border">Subtotal</th>
          <th class="p-2 border">#</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border p-2">
            <select name="barang_id[]" class="border p-2 rounded w-full" required>
              <option value="">- Pilih Barang -</option>
              <?php while($row = mysqli_fetch_assoc($barang)) : ?>
                <option value="<?= $row['barang_id'] ?>" data-harga="<?= $row['harga_beli'] ?>">
                    <?= $row['nama_barang'] ?>
                </option>
              <?php endwhile; ?>
            </select>
          </td>

          <td class="border p-2">
            <input type="number" name="harga_beli[]" class="harga border p-2 rounded w-full" required>
          </td>

          <td class="border p-2">
            <input type="number" name="jumlah[]" class="jumlah border p-2 rounded w-full" required>
          </td>

          <td class="border p-2">
            <input type="number" name="subtotal[]" class="subtotal border p-2 rounded w-full" readonly>
          </td>

          <td class="border p-2 text-center">
            <button type="button" class="hapus-row bg-red-500 text-white px-2 py-1 rounded">X</button>
          </td>
        </tr>
      </tbody>
    </table>

    <button type="button" id="tambah-row" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah Barang</button>

    <div class="mt-6">
      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Transaksi</button>
    </div>

  </div>
</form>

<script>
document.getElementById("tambah-row").addEventListener("click", function(){
  let table = document.querySelector("#tabel-barang tbody");
  let row = table.rows[0].cloneNode(true);
  row.querySelectorAll("input").forEach(i => i.value = "");
  table.appendChild(row);
});

document.addEventListener("input", function(e){
  if(e.target.classList.contains("jumlah") || e.target.classList.contains("harga")){
    let row = e.target.closest("tr");
    let harga = row.querySelector(".harga").value;
    let jumlah = row.querySelector(".jumlah").value;
    row.querySelector(".subtotal").value = harga * jumlah;
  }
});

document.addEventListener("change", function(e){
  if(e.target.tagName === "SELECT"){
    let harga = e.target.selectedOptions[0].getAttribute("data-harga");
    e.target.closest("tr").querySelector(".harga").value = harga;
  }
});
</script>

<?php include "../../layouts/footer.php"; ?>
