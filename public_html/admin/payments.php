<?php
require_once '../config/database.php';
session_start();

// Autentikasi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Ambil data pembayaran
$payments = $pdo->query("
    SELECT b.id, u.name, s.type, b.transfer_proof, b.status
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN services s ON b.service_id = s.id
    ORDER BY b.id DESC
")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h3 class="mb-4 text-center">📦 Daftar Bukti Pembayaran</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($payments)): ?>
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data pembayaran.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($payments as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= htmlspecialchars($p['type']) ?></td>
                            <td>
                                <?php if ($p['status'] === 'pending'): ?>
                                    <span class="badge badge-warning">Menunggu</span>
                                <?php elseif ($p['status'] === 'confirmed'): ?>
                                    <span class="badge badge-success">Dikonfirmasi</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?= htmlspecialchars($p['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($p['transfer_proof'])): ?>
                                    <a href="<?= htmlspecialchars($p['transfer_proof']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
