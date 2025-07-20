<?php
// Cek login jika diperlukan
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
?>

<!-- Tambahkan Bootstrap Icons jika belum -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .hero-box {
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        padding: 40px;
        transition: transform 0.3s ease;
    }
    .hero-box:hover {
        transform: scale(1.01);
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="hero-box text-center">
                <h1 class="mb-4 fw-bold text-primary"><i class="bi bi-car-front-fill me-2"></i>Selamat Datang di Travel Mobil</h1>
                <p class="lead mb-4">
                    Kami siap melayani kebutuhan perjalanan Anda dengan layanan carter, reguler, pelayanan dalam kota, dan pengiriman cargo.
                </p>
                <a href="booking.php" class="btn btn-success btn-lg px-5 py-3 shadow-sm">
                    <i class="bi bi-calendar-check me-2"></i> Booking Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
