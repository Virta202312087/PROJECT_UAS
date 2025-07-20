<?php
session_start();
require_once '../config/database.php';

// Autentikasi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Ambil semua jadwal + informasi layanan dan kendaraan
    $stmt = $pdo->query("
            SELECT sch.*, s.type AS service_type, r.origin, r.destination, v.brand AS vehicle_name
            FROM schedules sch
            JOIN services s ON sch.service_id = s.id
            JOIN routes r ON sch.route_id = r.id
            JOIN vehicles v ON sch.vehicle_id = v.id
            ORDER BY sch.departure_time ASC

    ");
    $schedules = $stmt->fetchAll();

    // Hitung booking yang dibatalkan
    $cancel_stmt = $pdo->query("SELECT COUNT(*) AS total_cancelled FROM bookings WHERE status = 'cancelled'");
    $cancelled = $cancel_stmt->fetchColumn();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>❌ Gagal memuat data: " . htmlspecialchars($e->getMessage()) . "</div>";
    $schedules = [];
    $cancelled = 0;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📅 Manajemen Jadwal Keberangkatan</h2>

    <div class="mb-3 text-right">
        <a href="add_schedule.php" class="btn btn-success">➕ Tambah Jadwal</a>
    </div>

    <?php if ($cancelled > 0): ?>
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            <div>⚠️ Ada <strong><?= $cancelled ?></strong> booking yang dibatalkan.</div>
            <form action="delete_cancelled_bookings.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua booking yang dibatalkan?');">
                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus Booking Dibatalkan</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Layanan</th>
                    <th>Kendaraan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($schedules)): ?>
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data jadwal.</td></tr>
                <?php else: ?>
                    <?php foreach ($schedules as $s): ?>
                        <tr class="text-center">
                            <td><?= $s['id'] ?></td>
                            <td><?= htmlspecialchars(ucfirst($s['service_type'])) ?>: <?= htmlspecialchars($s['origin']) ?> - <?= htmlspecialchars($s['destination']) ?></td>
                            <td><?= htmlspecialchars($s['vehicle_name']) ?></td>
                            <td><?= date('d-m-Y', strtotime($s['departure_time'])) ?></td>
                            <td><?= date('H:i', strtotime($s['departure_time'])) ?></td>
                            <td>Rp<?= number_format($s['price'], 0, ',', '.') ?></td>
                            <td>
                                <a href="edit_schedule.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">✏️ Edit</a>
                                <a href="delete_schedule.php?id=<?= $s['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?');">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
