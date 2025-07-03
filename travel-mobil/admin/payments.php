<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$payments = $pdo->query("SELECT b.id, u.name, s.type, b.transfer_proof, b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN services s ON b.service_id = s.id
    ORDER BY b.id DESC")->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2>Daftar Bukti Pembayaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr><th>User</th><th>Layanan</th><th>Status</th><th>Bukti Transfer</th></tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['type']) ?></td>
                    <td><?= htmlspecialchars($p['status']) ?></td>
                    <td>
                        <?php if ($p['transfer_proof']): ?>
                            <a href="<?= $p['transfer_proof'] ?>" target="_blank">Lihat</a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
