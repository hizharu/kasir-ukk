<?php include __DIR__ . "/../config/base_url.php"; ?>
<div class="w-64 h-screen bg-white shadow-xl fixed flex flex-col">
  <!-- Header/Brand -->
  <div class="p-6 border-b border-gray-200">
    <div class="flex items-center space-x-3">
      <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-2">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
      </div>
      <div>
        <h1 class="font-bold text-xl text-gray-800">Kasir App</h1>
        <p class="text-xs text-gray-500">Management System</p>
      </div>
    </div>
  </div>

  <nav class="flex-1 overflow-y-auto py-4 px-3">
    <!-- Dashboard -->
    <a href="<?= $base_url ?>pages/dashboard.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 hover:text-blue-600 transition-colors duration-200 group mb-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
      </svg>
      <span class="font-medium">Dashboard</span>
</a>
    <!-- Transaksi Section -->
    <div class="mt-6 mb-2">
      <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Transaksi</p>
    </div>

    <a href="<?= $base_url ?>pages/penjualan/create.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 hover:text-blue-600 transition-colors duration-200 group mb-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <span class="font-medium">Penjualan</span>
    </a>

        <!-- Laporan Section -->
    <div class="mt-6 mb-2">
      <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Laporan</p>
    </div>
     <a href="<?= $base_url ?>pages/laporan/penjualan.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-gray-100 text-gray-700 hover:text-blue-600 transition-colors duration-200 group mb-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
      <span class="font-medium">Laporan Penjualan</span>
    </a>
  </nav>
  <!-- Logout Button -->
  <div class="p-3 border-t border-gray-200">
    <a href="<?= $base_url ?>logout.php" class="flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-red-50 text-red-500 hover:text-red-600 transition-colors duration-200 group">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
      </svg>
      <span class="font-medium">Logout</span>
    </a>
  </div>
</div>



<div class="ml-64 w-full p-6">
