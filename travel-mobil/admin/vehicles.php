<?php
// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Fungsi untuk memeriksa apakah user adalah admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// ✅ Cek login admin
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

// Koneksi database dan header
require_once '../config/database.php';
include '../includes/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Manajemen Kendaraan</h1>

    <!-- Tampilkan daftar kendaraan di sini -->
    <?php
    $stmt = $pdo->query("SELECT * FROM vehicles ORDER BY id DESC");
    $vehicles = $stmt->fetchAll();

    if (count($vehicles) > 0): ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Kendaraan</th>
                    <th>Tipe</th>
                    <th>Plat Nomor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= $vehicle['id']; ?></td>
                        <td><?= $vehicle['name']; ?></td>
                        <td><?= $vehicle['type']; ?></td>
                        <td><?= $vehicle['license_plate']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Belum ada data kendaraan.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
