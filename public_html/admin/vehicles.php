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

require_once '../config/database.php';
include '../includes/header.php';

// Ambil data kendaraan dari database
try {
    $stmt = $pdo->query("SELECT * FROM vehicles ORDER BY id DESC");
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $vehicles = [];
    $error = $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">🚗 Manajemen Kendaraan</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">❌ Gagal memuat data kendaraan: <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (count($vehicles) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nama Kendaraan</th>
                        <th>Tipe</th>
                        <th>Plat Nomor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($vehicle['id']) ?></td>
                            <td><?= htmlspecialchars($vehicle['name']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($vehicle['type']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($vehicle['license_plate']) ?></td>
                            <td class="text-center">
                                <a href="edit_vehicle.php?id=<?= $vehicle['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_vehicle.php?id=<?= $vehicle['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kendaraan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Belum ada kendaraan yang terdaftar.</div>
    <?php endif; ?>

    <div class="mt-3 text-center">
        <a href="add_vehicle.php" class="btn btn-success">+ Tambah Kendaraan</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
