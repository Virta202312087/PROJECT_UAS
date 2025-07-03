<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Fungsi harus didefinisikan sebelum digunakan
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// ✅ Baru dipanggil di sini
if (!isAdmin()) {
    header("Location: ../admin/login.php");
    exit();
}

require_once '../config/database.php'; // koneksi jika diperlukan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Laporan Pengguna - Travel Mobil</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="../index.php">Travel Mobil</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?php if(isAdmin()): ?>
                    <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php">Dashboard Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="../reports/user_report.php">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="../admin/logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center">Laporan Pengguna</h1>
        <!-- Konten laporan pengguna akan ditampilkan di sini -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
