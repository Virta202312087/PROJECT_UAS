<?php
// Include header (pastikan file exists dan berisi tag <head> dan pembuka <body>)
include 'includes/header.php';
?>

<div class="container text-center mt-5">
    <h1 class="mb-4">Selamat Datang di Layanan Travel Mobil</h1>
    <p class="mb-5">Silakan pilih layanan yang Anda inginkan.</p>
    <div class="row justify-content-center">
        <div class="col-6 col-md-3 mb-3">
            <a href="/travel-mobil/user/index.php" class="btn btn-primary btn-lg w-100" role="button" aria-label="Customer">Customer</a>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <a href="/travel-mobil/admin/index.php" class="btn btn-success btn-lg w-100" role="button" aria-label="Admin">Admin</a>
        </div>
    </div>
</div>

<?php
// Include footer (pastikan file berisi penutup </body> dan </html>)
include 'includes/footer.php';
?>
