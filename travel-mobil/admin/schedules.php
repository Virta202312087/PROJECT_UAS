<?php
// Mulai session & validasi admin
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';

// Ambil semua jadwal (JOIN ke services dan vehicles)
$query = "
    SELECT sch.*, s.price, s.type AS service_type, s.origin, s.destination, v.name AS vehicle_name
    FROM schedules sch
    JOIN services s ON sch.service_id = s.id
    JOIN vehicles v ON sch.vehicle_id = v.id
    ORDER BY sch.departure_time ASC
";
$stmt = $pdo->query($query);
$schedules = $stmt->fetchAll();

// Hitung jumlah booking yang dibatalkan
$cancel_stmt = $pdo->query("SELECT COUNT(*) AS total_cancelled FROM bookings WHERE status = 'cancelled'");
$cancelled = $cancel_stmt->fetch()['total_cancelled'];
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Manajemen Jadwal</h2>

    <div class="mb-3">
        <a href="add_schedule.php" class="btn btn-success">+ Tambah Jadwal</a>
    </div>

    <?php if ($cancelled > 0): ?>
        <div class="alert alert-warning d-flex justify-content-between align-items-center">
            <div>⚠️ Ada <?= $cancelled ?> booking yang dibatalkan.</div>
            <form action="delete_cancelled_bookings.php" method="POST" onsubmit="return confirm('Hapus semua booking yang dibatalkan?')">
                <button type="submit" class="btn btn-danger btn-sm">Hapus Booking Cancelled</button>
            </form>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Layanan</th>
                <th>Kendaraan</th>
                <th>Tanggal Keberangkatan</th>
                <th>Waktu</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($schedules)): ?>
                <tr><td colspan="7" class="text-center">Belum ada data jadwal.</td></tr>
            <?php else: ?>
                <?php foreach ($schedules as $s): ?>
                    <tr>
                        <td><?= $s['id'] ?></td>
                        <td><?= ucfirst($s['service_type']) ?>: <?= $s['origin'] ?> - <?= $s['destination'] ?></td>
                        <td><?= $s['vehicle_name'] ?></td>
                        <td><?= date('d-m-Y', strtotime($s['departure_time'])) ?></td>
                        <td><?= date('H:i', strtotime($s['departure_time'])) ?></td>
                        <td>Rp<?= number_format($s['price'], 0, ',', '.') ?></td>
                        <td>
                            <a href="edit_schedule.php?id=<?= $s['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_schedule.php?id=<?= $s['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
