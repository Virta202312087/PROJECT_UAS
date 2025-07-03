<?php
include 'includes/header.php';
?>
<div class="container text-center mt-5">
    <h1 class="mb-4">Selamat Datang di Layanan Travel Mobil</h1>
    <p class="mb-5">Silakan pilih layanan yang Anda inginkan.</p>
    <div class="row justify-content-center">
        <div class="col-6 col-md-3 mb-3">
            <a href="/travel-mobil/user/index.php" class="btn btn-primary btn-lg w-100">Customer</a>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <a href="/travel-mobil/admin/index.php" class="btn btn-success btn-lg w-100">Admin</a>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <a href="/travel-mobil/reports/index.php" class="btn btn-warning btn-lg w-100">Reports</a>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-12 col-md-3">
            <button onclick="window.history.back();" class="btn btn-secondary btn-lg w-100">Kembali</button>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
