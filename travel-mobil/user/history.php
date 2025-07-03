<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

// Ambil filter dari form
$status_filter = $_GET['status'] ?? '';
$type_filter = $_GET['type'] ?? '';

$query = "SELECT b.*, s.origin, s.destination, s.type 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          WHERE b.user_id = :user_id";
$params = ['user_id' => $_SESSION['user_id']];

if ($status_filter !== '') {
    $query .= " AND b.status = :status";
    $params['status'] = $status_filter;
}
if ($type_filter !== '') {
    $query .= " AND s.type = :type";
    $params['type'] = $type_filter;
}

$query .= " ORDER BY b.booking_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$bookings = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Histori Booking Anda</h2>

    <form class="form-inline mb-3" method="GET">
        <label class="mr-2">Status:</label>
        <select name="status" class="form-control mr-3">
            <option value="">Semua</option>
            <option value="pending" <?= $status_filter === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= $status_filter === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="cancelled" <?= $status_filter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>

        <label class="mr-2">Layanan:</label>
        <select name="type" class="form-control mr-3">
            <option value="">Semua</option>
            <option value="carter" <?= $type_filter === 'carter' ? 'selected' : '' ?>>Carter</option>
            <option value="reguler" <?= $type_filter === 'reguler' ? 'selected' : '' ?>>Reguler</option>
            <option value="pelayanan" <?= $type_filter === 'pelayanan' ? 'selected' : '' ?>>Pelayanan</option>
            <option value="cargo" <?= $type_filter === 'cargo' ? 'selected' : '' ?>>Cargo</option>
        </select>

        <button type="submit" class="btn btn-primary mr-2">Filter</button>
        <a href="export_pdf.php?status=<?= $status_filter ?>&type=<?= $type_filter ?>" class="btn btn-danger" target="_blank">Export PDF</a>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Layanan</th>
                <th>Rute</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Kursi</th>
                <th>Bukti Transfer</th>
                <th>Foto Cargo</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($bookings) === 0): ?>
            <tr><td colspan="8" class="text-center">Tidak ada data booking</td></tr>
        <?php else: ?>
            <?php foreach ($bookings as $index => $b): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= ucfirst($b['type']) ?></td>
                    <td><?= $b['origin'] ?> - <?= $b['destination'] ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($b['booking_date'])) ?></td>
                    <td><span class="badge badge-<?= $b['status'] === 'pending' ? 'warning' : ($b['status'] === 'confirmed' ? 'success' : 'secondary') ?>">
                        <?= ucfirst($b['status']) ?>
                    </span></td>
                    <td><?= $b['seat'] ?: '-' ?></td>
                    <td>
                        <?php if ($b['transfer_proof']): ?>
                            <a href="<?= htmlspecialchars($b['transfer_proof']) ?>" target="_blank">Lihat</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($b['cargo_photo']): ?>
                            <a href="<?= htmlspecialchars($b['cargo_photo']) ?>" target="_blank">Lihat</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
