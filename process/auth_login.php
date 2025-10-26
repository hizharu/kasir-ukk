<?php
session_start();
include "../config/database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM kasir_app_pengguna WHERE username='$username' LIMIT 1");
$data = mysqli_fetch_assoc($query);

if($data){
    if(password_verify($password, $data['password'])){
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
        $_SESSION['level'] = $data['level'];

        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../login.php?error=Password salah!");
        exit;
    }
} else {
    header("Location: ../login.php?error=Username tidak ditemukan!");
    exit;
}
?>
