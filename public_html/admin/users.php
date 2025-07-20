<?php
session_start();

// Fungsi validasi admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';
include '../includes/header.php';

// Ambil data pengguna
try {
    $stmt = $pdo->query("SELECT id, username, role FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
    $error = $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">👤 Manajemen Pengguna</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">❌ Gagal mengambil data: <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) === 0): ?>
                    <tr><td colspan="4" class="text-center">Belum ada pengguna terdaftar.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td class="text-center"><?= htmlspecialchars(ucfirst($user['role'])) ?></td>
                            <td class="text-center">
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
