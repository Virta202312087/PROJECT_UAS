<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}
include '../includes/header.php';
?>
<div class="container">
    <h1>Dashboard Admin</h1>
    <p>Selamat datang di dashboard admin.</p>
    <a href="users.php" class="btn btn-primary">Manajemen Pengguna</a>
    <a href="vehicles.php" class="btn btn-primary">Manajemen Kendaraan</a>
    <a href="services.php" class="btn btn-primary">Manajemen Layanan</a>
    <a href="reports.php" class="btn btn-primary">Laporan</a>
    <a href="settings.php" class="btn btn-primary">Pengaturan</a>
</div>
<?php include '../includes/footer.php'; ?>
