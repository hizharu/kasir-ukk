<?php
include("../../config/database.php");
session_start();

// Validasi login
if(!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Get filter dates
$tanggal_awal = $_POST['tanggal_awal'] ?? date('Y-m-01');
$tanggal_akhir = $_POST['tanggal_akhir'] ?? date('Y-m-d');

// Query data
$query = "SELECT p.*, u.nama as nama_kasir 
          FROM kasir_app_penjualan p
          LEFT JOIN kasir_app_pengguna u ON p.user_id = u.user_id
          WHERE p.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
          ORDER BY p.tanggal DESC, p.penjualan_id DESC";
$result = mysqli_query($conn, $query);

// Set headers for Excel download
$filename = "Laporan_Penjualan_" . date('d-m-Y', strtotime($tanggal_awal)) . "_" . date('d-m-Y', strtotime($tanggal_akhir)) . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// Calculate totals
$total_transaksi = mysqli_num_rows($result);
$total_pendapatan = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENJUALAN</h2>
        <p>Periode: <?= date('d F Y', strtotime($tanggal_awal)) ?> - <?= date('d F Y', strtotime($tanggal_akhir)) ?></p>
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)): 
                $total_pendapatan += $row['total_harga'];
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>PJ-<?= str_pad($row['penjualan_id'], 6, '0', STR_PAD_LEFT) ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                <td><?= $row['nama_kasir'] ?? 'N/A' ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="summary">
        <p>Total Transaksi: <?= $total_transaksi ?></p>
        <p>Total Pendapatan: Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></p>
        <p>Rata-rata per Transaksi: Rp <?= $total_transaksi > 0 ? number_format($total_pendapatan / $total_transaksi, 0, ',', '.') : 0 ?></p>
    </div>
</body>
</html>