<?php
include(__DIR__ . '/../../config/database.php');
include($base_path . '/config/auth.php');

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM kasir_app_barang WHERE barang_id = '$id'");

echo "<script>alert('Barang berhasil dihapus!'); window.location='index.php';</script>";
