<?php
include(__DIR__ . '/../../config/database.php');
include($base_path . '/config/auth.php');

$id = $_GET['id'];

// Ambil data barang berdasarkan ID
$q = mysqli_query($conn, "SELECT * FROM kasir_app_barang WHERE barang_id = '$id'");
$data = mysqli_fetch_assoc($q);

// Kalau barang gak ada
if(!$data){
    echo "<script>alert('Barang tidak dite  mukan!'); window.location='index.php';</script>";
    exit;
}
?>

<?php include($base_path . '/layouts/header.php'); ?>
<?php include($base_path . '/layouts/sidebar_admin.php'); ?>

<div class="p-6">
    
    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm">
        Mengedit Barang: <strong><?= $data['nama_barang']; ?></strong>
    </span>

    <h2 class="text-xl font-semibold mt-4 mb-3">Edit Barang</h2>

    <form action="" method="POST" class="space-y-3 max-w-md">

        <div>
            <label class="text-gray-700 text-sm">Nama Barang</label>
            <input type="text" name="nama_barang" required
            value="<?= $data['nama_barang']; ?>"
            class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="text-gray-700 text-sm">Harga Beli</label>
            <input type="number" name="harga_beli" required
            value="<?= $data['harga_beli']; ?>"
            class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="text-gray-700 text-sm">Harga Jual</label>
            <input type="number" name="harga_jual" required
            value="<?= $data['harga_jual']; ?>"
            class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="text-gray-700 text-sm">Stok</label>
            <input type="number" name="stok" required
            value="<?= $data['stok']; ?>"
            class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" name="update"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
</div>

<?php include($base_path . '/layouts/footer.php'); ?>

<?php
// Proses Update
if(isset($_POST['update'])){
    $nama = $_POST['nama_barang'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];

    if($harga_beli < 0 || $harga_jual < 0 || $stok < 0){
        echo "<script>alert('Harga dan stok tidak boleh negatif!');</script>";
    } else {
        mysqli_query($conn, "UPDATE kasir_app_barang SET 
            nama_barang='$nama', 
            harga_beli='$harga_beli', 
            harga_jual='$harga_jual', 
            stok='$stok'
            WHERE barang_id='$id'
        ");
        echo "<script>alert('Berhasil diupdate!'); window.location='index.php';</script>";
    }
}

?>
