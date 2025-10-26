<?php
include(__DIR__ . '/../config/database.php');
session_start();
$user_id = $_SESSION['user_id'] ?? 1;

if(isset($_POST['barang_id'])) {

    $tanggal = $_POST['tanggal'];
    $barang_id_arr = $_POST['barang_id'];
    $harga_jual_arr = $_POST['harga_jual'];
    $qty_arr = $_POST['jumlah'];

    $total_harga = 0;
    for($i=0; $i<count($barang_id_arr); $i++){
        $total_harga += $harga_jual_arr[$i] * $qty_arr[$i];
    }

    // insert header penjualan
    $query_header = mysqli_query($conn, "INSERT INTO kasir_app_penjualan (tanggal, total_harga, user_id)
                         VALUES ('$tanggal','$total_harga','$user_id')");
    
    if(!$query_header) {
        header("Location: ../../pages/penjualan/create.php?error=" . urlencode("Gagal menyimpan transaksi"));
        exit;
    }
    
    $penjualan_id = mysqli_insert_id($conn);

    // insert detail & update stok
    for($i=0; $i<count($barang_id_arr); $i++){
        $id_barang = $barang_id_arr[$i];
        $harga = $harga_jual_arr[$i];
        $jumlah = $qty_arr[$i];
        $subtotal = $harga * $jumlah;

        mysqli_query($conn, "INSERT INTO kasir_app_detail_penjualan (penjualan_id, barang_id, jumlah, harga_jual, subtotal)
                             VALUES ('$penjualan_id','$id_barang','$jumlah','$harga','$subtotal')");

        // update stok turun
        mysqli_query($conn, "UPDATE kasir_app_barang SET stok = stok - $jumlah WHERE barang_id='$id_barang'");
    }

    header("Location: ../../pages/penjualan/create.php?success=1&id=" . $penjualan_id . "&total=" . $total_harga);
    exit;
} else {
    header("Location: ../../pages/penjualan/create.php?error=" . urlencode("Tidak ada data barang yang dikirim"));
    exit;
}
?>