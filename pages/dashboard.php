<?php
include(__DIR__ . '/../config/database.php');
include($base_path . "/config/auth.php");
include($base_path . "/layouts/header.php");

if($_SESSION['level'] === 'administrator'){
    include($base_path . "/layouts/sidebar_admin.php");
} else {
    include ($base_path . "/layouts/sidebar_petugas.php");
}

// Query untuk menghitung total data
$query_barang = "SELECT COUNT(*) as total FROM kasir_app_barang";
$query_penjualan = "SELECT COUNT(*) as total, COALESCE(SUM(total_harga), 0) as total_harga FROM kasir_app_penjualan";
$query_pembelian = "SELECT COUNT(*) as total, COALESCE(SUM(total_harga), 0) as total_harga FROM kasir_app_pembelian";
$query_pengguna = "SELECT COUNT(*) as total FROM kasir_app_pengguna";

$result_barang = mysqli_query($conn, $query_barang);
$result_penjualan = mysqli_query($conn, $query_penjualan);
$result_pembelian = mysqli_query($conn, $query_pembelian);
$result_pengguna = mysqli_query($conn, $query_pengguna);

$data_barang = mysqli_fetch_assoc($result_barang);
$data_penjualan = mysqli_fetch_assoc($result_penjualan);
$data_pembelian = mysqli_fetch_assoc($result_pembelian);
$data_pengguna = mysqli_fetch_assoc($result_pengguna);
?>

<div class="p-6">
  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 mt-1">Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?></p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Barang -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-blue-100 text-sm font-medium mb-1">Total Barang</p>
          <p class="text-3xl font-bold"><?= number_format($data_barang['total']) ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Penjualan -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100 text-sm font-medium mb-1">Total Penjualan</p>
          <p class="text-3xl font-bold"><?= number_format($data_penjualan['total']) ?></p>
          <p class="text-green-100 text-xs mt-1">Rp <?= number_format($data_penjualan['total_harga'], 0, ',', '.') ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Pembelian -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-purple-100 text-sm font-medium mb-1">Total Pembelian</p>
          <p class="text-3xl font-bold"><?= number_format($data_pembelian['total']) ?></p>
          <p class="text-purple-100 text-xs mt-1">Rp <?= number_format($data_pembelian['total_harga'], 0, ',', '.') ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Pengguna -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-orange-100 text-sm font-medium mb-1">Total Pengguna</p>
          <p class="text-3xl font-bold"><?= number_format($data_pengguna['total']) ?></p>
        </div>
        <div class="bg-white bg-opacity-20 rounded-full p-3">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
          </svg>
        </div>
      </div>
    </div>

  </div>

  <!-- Recent Activity Section (Optional) -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Quick Info -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Cepat</h3>
      <div class="space-y-3">
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <span class="text-gray-600">Status Sistem</span>
          <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">Aktif</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <span class="text-gray-600">Level Akses</span>
          <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium"><?= ucfirst($_SESSION['level']) ?></span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <span class="text-gray-600">Terakhir Login</span>
          <span class="text-gray-800 text-sm font-medium"><?= date('d M Y, H:i') ?></span>
        </div>
      </div>
    </div>

    <!-- Statistics Summary -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Statistik</h3>
      <div class="space-y-4">
        <div>
          <div class="flex justify-between text-sm mb-1">
            <span class="text-gray-600">Barang Tersedia</span>
            <span class="font-semibold text-gray-800"><?= $data_barang['total'] ?> item</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-500 h-2 rounded-full" style="width: 100%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between text-sm mb-1">
            <span class="text-gray-600">Transaksi Penjualan</span>
            <span class="font-semibold text-gray-800"><?= $data_penjualan['total'] ?> transaksi</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
          </div>
        </div>
        <div>
          <div class="flex justify-between text-sm mb-1">
            <span class="text-gray-600">Transaksi Pembelian</span>
            <span class="font-semibold text-gray-800"><?= $data_pembelian['total'] ?> transaksi</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-500 h-2 rounded-full" style="width: 70%"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include ($base_path . "/layouts/footer.php"); ?>