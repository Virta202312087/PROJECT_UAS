<?php
session_start();
require_once '../config/database.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Proses penambahan rute
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origin = $_POST['origin'] ?? '';
    $destination = $_POST['destination'] ?? '';

    if ($origin && $destination) {
        $stmt = $pdo->prepare("INSERT INTO routes (origin, destination) VALUES (:origin, :destination)");
        $stmt->execute(['origin' => $origin, 'destination' => $destination]);
        header("Location: routes.php?success=1");
        exit();
    }
}

// Ambil semua rute
$routes = $pdo->query("SELECT * FROM routes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('../includes/header.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4">Manajemen Rute</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">✅ Rute berhasil ditambahkan!</div>
    <?php endif; ?>

    <form method="POST" class="form-inline mb-3">
        <div class="form-group mr-2">
            <input type="text" name="origin" class="form-control" placeholder="Asal" required>
        </div>
        <div class="form-group mr-2">
            <input type="text" name="destination" class="form-control" placeholder="Tujuan" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Rute</button>
    </form>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($routes as $route): ?>
                <tr>
                    <td><?= htmlspecialchars($route['origin']) ?></td>
                    <td><?= htmlspecialchars($route['destination']) ?></td>
                    <td>
                        <!-- Tambahkan fitur hapus/edit jika diperlukan -->
                        <form method="POST" action="delete_route.php" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus rute ini?');">
                            <input type="hidden" name="route_id" value="<?= $route['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
