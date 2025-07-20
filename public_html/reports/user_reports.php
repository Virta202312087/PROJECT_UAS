<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Fungsi harus didefinisikan sebelum digunakan
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: ../admin/login.php");
    exit();
}

require_once '../config/database.php';

// Ambil data pengguna untuk laporan
$stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Laporan Pengguna - Travel Mobil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php">
            <i class="fa-solid fa-car-side me-2"></i>Travel Mobil
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="user_report.php">Laporan Pengguna</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="../admin/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📊 Laporan Data Pengguna</h2>

    <?php if (count($users) === 0): ?>
        <div class="alert alert-info">Belum ada data pengguna yang terdaftar.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $u): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($u['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<footer class="bg-light border-top mt-5 py-3 text-center">
    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Travel Mobil. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
