<?php
include '../includes/header.php'; // Gunakan path relatif yang tepat
?>
<div class="container text-center mt-5">
    <h1 class="mb-4">Selamat Datang di Halaman Laporan</h1>
    <p class="mb-5">Silakan pilih akses yang sesuai untuk melihat laporan atau kembali ke menu utama.</p>

    <div class="row justify-content-center">
        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <a href="/travel-mobil/user/index.php" class="btn btn-primary btn-lg w-100">
                <i class="fa-solid fa-users me-2"></i>Customer
            </a>
        </div>
        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <a href="/travel-mobil/admin/index.php" class="btn btn-success btn-lg w-100">
                <i class="fa-solid fa-user-shield me-2"></i>Admin
            </a>
        </div>
        <div class="col-12 col-md-4 col-lg-3 mb-3">
            <a href="/travel-mobil/reports/view_reports.php" class="btn btn-warning btn-lg w-100 text-dark">
                <i class="fa-solid fa-chart-line me-2"></i>View Reports
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-4 col-lg-3">
            <button onclick="window.history.back();" class="btn btn-secondary btn-lg w-100">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali
            </button>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
