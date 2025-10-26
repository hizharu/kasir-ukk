<?php
include(__DIR__ . '/../config/database.php');

// Ambil data dari form
$nama_barang = $_POST['nama_barang'];
$kategori    = $_POST['kategori'];
$harga_beli  = $_POST['harga_beli'];
$harga_jual  = $_POST['harga_jual'];
$stok        = $_POST['stok'];
$satuan      = $_POST['satuan'];

// Query simpan
$query = "INSERT INTO kasir_app_barang (nama_barang, kategori, harga_beli, harga_jual, stok, satuan)
          VALUES ('$nama_barang', '$kategori', '$harga_beli', '$harga_jual', '$stok', '$satuan')";

$result = mysqli_query($conn, $query);

if($result){
    // Berhasil → balik ke halaman list barang
    header("Location: ../pages/barang/index.php?status=sukses");
    exit;
}else{
    // Gagal → balik juga tapi kasih pesan
    header("Location: ../pages/barang/index.php?status=gagal");
    exit;
}
