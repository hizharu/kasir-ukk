<?php
$base_url = "http://localhost/kasir_app/";
$base_path = __DIR__ . "/.."; // ini mengarah ke folder kasir_app_project
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kasir_app";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
