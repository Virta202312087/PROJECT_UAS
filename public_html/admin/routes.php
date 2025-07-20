<?php
session_start();
require_once '../config/database.php';

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle tambah rute
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origin = trim($_POST['origin'] ?? '');
    $destination = trim($_POST['destination'] ?? '');

    // Validasi sederhana
    if ($origin && $destination) {
        try {
            $stmt = $pdo->prepare("INSERT INTO routes (origin, destination) VALUES (:origin, :destination)");
            $stmt->execute(['origin' => $origin, 'destination' => $destination]);
            header("Location: routes.php?success=1");
            exit();
        } catch (PDOException $e) {
            header("Location: routes.php?error=1");
            exit();
        }
    }
}

// Ambil semua rute
$routes = $pdo->query("SELECT * FROM routes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">🚐 Manajemen Rute Perjalanan</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Rute berhasil ditambahkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ❌ Gagal menambahkan rute. Silakan coba lagi.
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Rute -->
    <form method="POST" class="form-inline justify-content-center mb-4">
        <div class="form-group mr-2">
            <input type="text" name="origin" class="form-control" placeholder="Asal" required>
        </div>
        <div class="form-group mr-2">
            <input type="text" name="destination" class="form-control" placeholder="Tujuan" required>
        </div>
        <button type="submit" class="btn btn-primary">➕ Tambah Rute</button>
    </form>

    <!-- Tabel Daftar Rute -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($routes)): ?>
                    <tr><td colspan="3" class="text-center text-muted">Belum ada rute yang ditambahkan.</td></tr>
                <?php else: ?>
                    <?php foreach ($routes as $route): ?>
                        <tr class="text-center">
                            <td><?= htmlspecialchars($route['origin']) ?></td>
                            <td><?= htmlspecialchars($route['destination']) ?></td>
                            <td>
                                <form method="POST" action="delete_route.php" style="display:inline;" 
                                      onsubmit="return confirm('Yakin ingin menghapus rute ini?');">
                                    <input type="hidden" name="route_id" value="<?= $route['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
