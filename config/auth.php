<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . '/database.php'); // ganti ini, bukan koneksi.php

if(!isset($_SESSION['user_id'])){ // sesuaikan yang kamu pakai
    header("Location: " . $base_url . "login.php");
    exit;
}