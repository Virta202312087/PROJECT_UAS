<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

// Cek apakah pengguna adalah admin
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}
?>

<!-- Header -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
        }
        .navbar {
            background-color: #00796b;
        }
        .navbar-brand {
            font-weight: 700;
            color: #fff;
        }
        .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: #ffd54f !important;
        }
        .card-title {
            font-weight: 600;
            color: #00796b;
        }
        .card-text {
            color: #555;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar Admin -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-house-door me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php"><i class="bi bi-people me-1"></i>Pengguna</a></li>
                <li class="nav-item"><a class="nav-link" href="vehicles.php"><i class="bi bi-truck me-1"></i>Kendaraan</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php"><i class="bi bi-tools me-1"></i>Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="reports.php"><i class="bi bi-file-earmark-bar-graph me-1"></i>Laporan</a></li>
                <li class="nav-item"><a class="nav-link" href="settings.php"><i class="bi bi-gear me-1"></i>Pengaturan</a></li>
                <li class="nav-item"><a class="nav-link text-warning" href="../logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten -->
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">📊 Dashboard Admin</h2>

    <div class="row">

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">👤 Pengguna</h5>
                    <p class="card-text">Kelola akun pengguna sistem.</p>
                    <a href="users.php" class="btn btn-outline-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">🚗 Kendaraan</h5>
                    <p class="card-text">Atur data armada travel mobil.</p>
                    <a href="vehicles.php" class="btn btn-outline-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">🛠️ Layanan</h5>
                    <p class="card-text">Carter, Reguler, Pelayanan, Cargo.</p>
                    <a href="services.php" class="btn btn-outline-primary btn-sm">Kelola</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">📑 Laporan</h5>
                    <p class="card-text">Lihat dan ekspor data laporan booking.</p>
                    <a href="reports.php" class="btn btn-outline-danger btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">⚙️ Pengaturan</h5>
                    <p class="card-text">Atur konfigurasi sistem & akun admin.</p>
                    <a href="settings.php" class="btn btn-outline-secondary btn-sm">Pengaturan</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Footer & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
