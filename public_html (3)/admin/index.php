<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

// Cek apakah admin sudah login
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Dashboard Admin</h2>
    <p class="text-center">Selamat datang di panel administrasi. Silakan pilih menu berikut:</p>

    <div class="row justify-content-center">

        <div class="col-md-4 mb-3">
            <a href="users.php" class="btn btn-primary w-100">
                👤 Manajemen Pengguna
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="vehicles.php" class="btn btn-success w-100">
                🚗 Manajemen Kendaraan
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="services.php" class="btn btn-info w-100">
                🛠️ Manajemen Layanan
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="reports.php" class="btn btn-danger w-100">
                📑 Laporan
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="settings.php" class="btn btn-secondary w-100">
                ⚙️ Pengaturan
            </a>
        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>
