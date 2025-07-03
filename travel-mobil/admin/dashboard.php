<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}
include '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Dashboard Admin</h2>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">👤 Pengguna</h5>
                    <p class="card-text">Kelola akun pengguna sistem.</p>
                    <a href="users.php" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">🚗 Kendaraan</h5>
                    <p class="card-text">Atur data armada travel mobil.</p>
                    <a href="vehicles.php" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">🛠️ Layanan</h5>
                    <p class="card-text">Carter, Reguler, Pelayanan, Cargo.</p>
                    <a href="services.php" class="btn btn-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">📑 Laporan</h5>
                    <p class="card-text">Lihat dan ekspor data laporan booking.</p>
                    <a href="reports.php" class="btn btn-danger btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">⚙️ Pengaturan</h5>
                    <p class="card-text">Atur konfigurasi sistem & akun admin.</p>
                    <a href="settings.php" class="btn btn-secondary btn-sm">Pengaturan</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
