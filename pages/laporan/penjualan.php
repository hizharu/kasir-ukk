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

// ambil data penjualan sesuai filter
$query = "SELECT kasir_app_penjualan.*, kasir_app_pengguna.nama_lengkap AS nama_kasir
          FROM kasir_app_penjualan
          LEFT JOIN kasir_app_pengguna ON kasir_app_penjualan.user_id = kasir_app_pengguna.user_id
          WHERE kasir_app_penjualan.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY kasir_app_penjualan.tanggal DESC, kasir_app_penjualan.penjualan_id DESC";
$result = mysqli_query($conn, $query);

// Hitung total dan statistik
$total_transaksi = mysqli_num_rows($result);
$total_pendapatan = 0;
$data_penjualan = [];

while($row = mysqli_fetch_assoc($result)) {
    $total_pendapatan += $row['total_harga'];
    $data_penjualan[] = $row;
}
?>

<div class="p-6">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Penjualan</h1>
        <p class="text-gray-500 mt-1">Kelola dan analisis data penjualan</p>
      </div>
      <div class="flex items-center space-x-3">
        <button onclick="window.print()" class="flex items-center space-x-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition duration-200 shadow-md hover:shadow-lg">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
          </svg>
          <span class="font-medium">Print</span>
        </button>
        <form method="POST" action="export_excel.php" class="inline">
          <input type="hidden" name="tanggal_awal" value="<?= $tanggal_awal ?>">
          <input type="hidden" name="tanggal_akhir" value="<?= $tanggal_akhir ?>">
          <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition duration-200 shadow-md hover:shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-medium">Export Excel</span>
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100 text-sm font-medium mb-1">Total Transaksi</p>
          <p class="text-3xl font-bold"><?= number_format($total_transaksi) ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100 text-sm font-medium mb-1">Total Pendapatan</p>
          <p class="text-3xl font-bold">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
      </div>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-orange-100 text-sm font-medium mb-1">Rata-rata Transaksi</p>
          <p class="text-3xl font-bold">Rp <?= $total_transaksi > 0 ? number_format($total_pendapatan / $total_transaksi, 0, ',', '.') : 0 ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
      <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
      </svg>
      Filter Laporan
    </h3>
    <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-gray-700 font-medium mb-2 text-sm">Tanggal Awal</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2 text-sm">Tanggal Akhir</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" class="pl-10 pr-4 py-3 border border-gray-300 rounded-lg w-full focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>
      </div>
      <div class="flex items-end">
        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center space-x-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <span>Filter</span>
        </button>
      </div>
      <div class="flex items-end">
        <a href="penjualan.php" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold text-center transition duration-200">
          Reset Filter
        </a>
      </div>
    </form>
  </div>

  <!-- Table Section -->
  <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
      <h3 class="text-lg font-semibold text-gray-800">Data Transaksi Penjualan</h3>
      <p class="text-sm text-gray-500 mt-1">Periode: <?= date('d M Y', strtotime($tanggal_awal)) ?> - <?= date('d M Y', strtotime($tanggal_akhir)) ?></p>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID Transaksi</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kasir</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Harga</th>
            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if(count($data_penjualan) > 0): ?>
            <?php $no = 1; foreach($data_penjualan as $row): ?>
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= $no++ ?></td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                  #PJ-<?= str_pad($row['penjualan_id'], 6, '0', STR_PAD_LEFT) ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                  <?= date('d M Y', strtotime($row['tanggal'])) ?>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  <?= $row['nama_kasir'] ?? 'N/A' ?>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm font-semibold text-green-600">
                  Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex items-center justify-center space-x-2">
                  <a href="penjualan_detail.php?id=<?= $row['penjualan_id'] ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Detail
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                  <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <p class="text-gray-500 font-medium">Tidak ada data penjualan</p>
                  <p class="text-gray-400 text-sm mt-1">Silakan ubah filter tanggal atau lakukan transaksi baru</p>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if(count($data_penjualan) > 0): ?>
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-600">
          Menampilkan <span class="font-semibold"><?= count($data_penjualan) ?></span> transaksi
        </p>
        <div class="text-sm font-semibold text-gray-700">
          Total Pendapatan: <span class="text-green-600">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></span>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<style>
@media print {
  .no-print {
    display: none;
  }
}
</style>

<?php include("../../layouts/footer.php"); ?>