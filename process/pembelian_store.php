<?php
include(__DIR__ . '/../config/database.php');

session_start();
$user_id = $_SESSION['user_id'] ?? 1; // default testing

if(isset($_POST['barang_id'])) {

    $tanggal = $_POST['tanggal'];
    $barang_id_arr = $_POST['barang_id'];
    $harga_beli_arr = $_POST['harga_beli'];
    $qty_arr = $_POST['jumlah'];

    // hitung total
    $total_harga = 0;
    for($i=0; $i<count($barang_id_arr); $i++){
        $total_harga += $harga_beli_arr[$i] * $qty_arr[$i];
    }

    // insert header (anggap user_id optional)
    $sql = "INSERT INTO kasir_app_pembelian (tanggal, total_harga, user_id)
            VALUES ('$tanggal','$total_harga','$user_id')";
    mysqli_query($conn, $sql);
    $pembelian_id = mysqli_insert_id($conn);

    // insert detail & update stok
    for($i=0; $i<count($barang_id_arr); $i++){
        $id_barang = $barang_id_arr[$i];
        $harga = $harga_beli_arr[$i];
        $jumlah = $qty_arr[$i];
        $subtotal = $harga * $jumlah;

        // insert detail
        mysqli_query($conn, "INSERT INTO kasir_app_detail_pembelian (pembelian_id, barang_id, jumlah, harga_beli, subtotal)
                             VALUES ('$pembelian_id','$id_barang','$jumlah','$harga','$subtotal')");

        // update stok
        mysqli_query($conn, "UPDATE kasir_app_barang SET stok = stok + $jumlah WHERE barang_id='$id_barang'");
    }

    header("Location: ../../pages/pembelian/create.php?success=1");
    exit;
} else {
    echo "Tidak ada data barang yang dikirim.";
}
?>
