<?php
include "../config/database.php";

$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$level     = $_POST['level'];

$query = "INSERT INTO kasir_app_pengguna (nama_lengkap, username, password, level) VALUES ('$nama_lengkap', '$username', '$password', '$level')";
$result = mysqli_query($conn, $query);

if($result){
    header("Location: ../pages/pengguna/index.php?status=sukses");
    exit;
}else{
    header("Location: ../pages/pengguna/index.php?status=gagal");
    exit;
}
