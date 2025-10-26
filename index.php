<?php
include "config/auth.php";

if($_SESSION['level'] === 'administrator'){
    include "pages/dashboard.php"; // khusus admin
} else {
    include "pages/dashboard.php"; // petugas langsung ke transaksi
}
