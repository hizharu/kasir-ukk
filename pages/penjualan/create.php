<?php
include("../../config/database.php");
include("../../layouts/header.php");
$role = $_SESSION['level'] ?? 'petugas';
if($role === 'administrator'){
    include("../../layouts/sidebar_admin.php");
} else {
    include("../../layouts/sidebar_petugas.php");
}

// Ambil data barang
$barang = mysqli_query($conn, "SELECT * FROM kasir_app_barang ORDER BY nama_barang ASC");
?>

<div class="p-6">
    
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Tambah Penjualan</h1>
        <p class="text-gray-500 mt-1">Buat transaksi penjualan baru</p>
      </div>
      <a href="index.php" class="flex items-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Kembali</span>
      </a>
    </div>
  </div>

  <form action="../../process/penjualan_store.php" method="POST">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
      <!-- Main Form Section -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
          
          <!-- Info Section -->
          <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
            <div class="flex items-center space-x-3">
              <div class="bg-white bg-opacity-20 rounded-full p-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
              </div>
              <div>
                <h2 class="text-xl font-semibold text-white">Informasi Transaksi</h2>
                <p class="text-green-100 text-sm">ID Transaksi: #PJ-<?= date('YmdHis') ?></p>
              </div>
            </div>
          </div>

          <div class="p-6">
            <!-- Tanggal -->
            <div class="mb-6">
              <label class="block text-gray-700 font-medium mb-2">Tanggal Penjualan</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
                <input type="date" name="tanggal" value="<?= date('Y-m-d') ?>" class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
              </div>
            </div>

            <!-- Tabel Barang -->
            <div class="mb-4">
              <div class="flex items-center justify-between mb-3">
                <label class="text-gray-700 font-medium">Daftar Barang</label>
                <button type="button" id="tambah-row" class="flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                  </svg>
                  <span class="font-medium">Tambah Barang</span>
                </button>
              </div>

              <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full" id="tabel-barang">
                  <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                      <th class="p-3 text-left text-sm font-semibold text-gray-700 border-b">Barang</th>
                      <th class="p-3 text-left text-sm font-semibold text-gray-700 border-b">Harga</th>
                      <th class="p-3 text-left text-sm font-semibold text-gray-700 border-b">Jumlah</th>
                      <th class="p-3 text-left text-sm font-semibold text-gray-700 border-b">Subtotal</th>
                      <th class="p-3 text-center text-sm font-semibold text-gray-700 border-b w-20">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors">
                      <td class="p-3">
                        <select name="barang_id[]" class="border border-gray-300 p-2 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none" required>
                          <option value="">- Pilih Barang -</option>
                          <?php 
                          mysqli_data_seek($barang, 0);
                          while($row = mysqli_fetch_assoc($barang)) : ?>
                            <option value="<?= $row['barang_id'] ?>" data-harga="<?= $row['harga_jual'] ?>">
                                <?= $row['nama_barang'] ?>
                            </option>
                          <?php endwhile; ?>
                        </select>
                      </td>

                      <td class="p-3">
                        <div class="relative">
                          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                          <input type="number" name="harga_jual[]" class="harga border border-gray-300 pl-10 pr-3 py-2 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none" required>
                        </div>
                      </td>

                      <td class="p-3">
                        <input type="number" name="jumlah[]" min="1" class="jumlah border border-gray-300 p-2 rounded-lg w-full focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none" required>
                      </td>

                      <td class="p-3">
                        <div class="relative">
                          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm">Rp</span>
                          <input type="number" name="subtotal[]" class="subtotal border border-gray-300 pl-10 pr-3 py-2 rounded-lg w-full bg-gray-50" readonly>
                        </div>
                      </td>

                      <td class="p-3 text-center">
                        <button type="button" class="hapus-row bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition duration-200">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                          </svg>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Summary Section -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Transaksi</h3>
          
          <div class="space-y-3 mb-6">
            <div class="flex justify-between items-center py-2 border-b">
              <span class="text-gray-600">Total Item</span>
              <span class="font-semibold text-gray-800" id="total-item">0</span>
            </div>
            
            <div class="flex justify-between items-center py-2 border-b">
              <span class="text-gray-600">Subtotal</span>
              <span class="font-semibold text-gray-800" id="display-subtotal">Rp 0</span>
            </div>
            
            <div class="flex justify-between items-center py-3 bg-gradient-to-r from-green-50 to-green-100 px-4 rounded-lg">
              <span class="text-gray-700 font-semibold">Total Bayar</span>
              <span class="font-bold text-xl text-green-600" id="display-total">Rp 0</span>
            </div>
          </div>

          <div class="space-y-3">
            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center space-x-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
              </svg>
              <span>Simpan Transaksi</span>
            </button>
            
            <button type="button" onclick="window.location.href='penjualan/create.php'" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold transition duration-200">
              Batal
            </button>
          </div>

          <!-- Info Box -->
          <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start space-x-3">
              <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
              <div>
                <p class="text-sm font-medium text-blue-800">Tips</p>
                <p class="text-xs text-blue-600 mt-1">Pastikan semua data sudah terisi dengan benar sebelum menyimpan transaksi.</p>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </form>
</div>

<script>
// Tambah row baru
document.getElementById("tambah-row").addEventListener("click", function(){
  let table = document.querySelector("#tabel-barang tbody");
  let row = table.rows[0].cloneNode(true);
  row.querySelectorAll("input").forEach(i => i.value = "");
  row.querySelector("select").value = "";
  table.appendChild(row);
  updateSummary();
});

// Hapus row
document.addEventListener("click", function(e){
  if(e.target.closest(".hapus-row")){
    let table = document.querySelector("#tabel-barang tbody");
    if(table.rows.length > 1){
      e.target.closest("tr").remove();
      updateSummary();
    } else {
      alert("Minimal harus ada 1 barang!");
    }
  }
});

// Hitung subtotal
document.addEventListener("input", function(e){
  if(e.target.classList.contains("jumlah") || e.target.classList.contains("harga")){
    let row = e.target.closest("tr");
    let harga = parseFloat(row.querySelector(".harga").value) || 0;
    let jumlah = parseFloat(row.querySelector(".jumlah").value) || 0;
    row.querySelector(".subtotal").value = harga * jumlah;
    updateSummary();
  }
});

// Auto fill harga saat pilih barang
document.addEventListener("change", function(e){
  if(e.target.tagName === "SELECT" && e.target.name === "barang_id[]"){
    let harga = e.target.selectedOptions[0].getAttribute("data-harga");
    if(harga){
      e.target.closest("tr").querySelector(".harga").value = harga;
      // Trigger calculation
      let row = e.target.closest("tr");
      let jumlah = parseFloat(row.querySelector(".jumlah").value) || 0;
      row.querySelector(".subtotal").value = harga * jumlah;
      updateSummary();
    }
  }
});

// Update summary
function updateSummary(){
  let subtotals = document.querySelectorAll(".subtotal");
  let total = 0;
  let itemCount = 0;
  
  subtotals.forEach(function(sub){
    let val = parseFloat(sub.value) || 0;
    if(val > 0) itemCount++;
    total += val;
  });
  
  document.getElementById("total-item").textContent = itemCount;
  document.getElementById("display-subtotal").textContent = "Rp " + total.toLocaleString('id-ID');
  document.getElementById("display-total").textContent = "Rp " + total.toLocaleString('id-ID');
}

// Initial update
updateSummary();
</script>

<?php include("../../layouts/footer.php"); ?>