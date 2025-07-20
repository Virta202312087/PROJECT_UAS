<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'] ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna - Travel Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            margin: 0;
            padding-top: 70px;
        }

        .navbar {
            background-color: #0D47A1;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .card-option {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem 1.2rem;
        }

        .card-option:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
        }

        .card-option i {
            font-size: 2.8rem;
            margin-bottom: 0.8rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        footer {
            background-color: #f9f9f9;
            padding: 1.2rem 0;
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .card-option {
                padding: 1.5rem 1rem;
            }

            .card-option i {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="bi bi-house-door-fill me-2"></i>Travel Mobil</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<div class="container text-center">
    <div class="mb-5">
        <h3 class="text-primary fw-bold mt-4">Halo, <?= htmlspecialchars($user_name) ?> 👋</h3>
        <p class="text-muted">Silakan pilih layanan yang ingin Anda gunakan</p>
    </div>

    <div class="row g-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card-option h-100 text-center">
                <i class="bi bi-calendar-check text-primary"></i>
                <h5 class="card-title mt-2">Booking</h5>
                <p class="small text-muted">Pesan Carter, Reguler, Pelayanan, atau Cargo</p>
                <a href="booking.php" class="btn btn-outline-primary btn-sm mt-2">Mulai Booking</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-option h-100 text-center">
                <i class="bi bi-clock-history text-success"></i>
                <h5 class="card-title mt-2">Riwayat</h5>
                <p class="small text-muted">Lihat pemesanan yang pernah dilakukan</p>
                <a href="history.php" class="btn btn-outline-success btn-sm mt-2">Lihat Riwayat</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-option h-100 text-center">
                <i class="bi bi-person-circle text-info"></i>
                <h5 class="card-title mt-2">Profil</h5>
                <p class="small text-muted">Kelola informasi dan kata sandi Anda</p>
                <a href="profile.php" class="btn btn-outline-info btn-sm mt-2">Edit Profil</a>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card-option h-100 text-center">
                <i class="bi bi-chat-dots text-warning"></i>
                <h5 class="card-title mt-2">Ulasan</h5>
                <p class="small text-muted">Berikan kritik & saran untuk layanan</p>
                <a href="review.php" class="btn btn-outline-warning btn-sm mt-2">Kirim Ulasan</a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center mt-5">
    <div class="container">
        &copy; <?= date('Y') ?> Travel Mobil. Seluruh hak cipta dilindungi.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
