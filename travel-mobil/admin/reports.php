<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit();
}

require_once '../config/database.php';
include '../includes/header.php';

// Ambil filter tanggal dari query string
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

if ($start && $end) {
    $stmt = $pdo->prepare("
        SELECT s.type, COUNT(b.id) AS total
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE DATE(b.booking_date) BETWEEN :start AND :end
        GROUP BY s.type
    ");
    $stmt->execute(['start' => $start, 'end' => $end]);
} else {
    $stmt = $pdo->query("
        SELECT s.type, COUNT(b.id) AS total
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        GROUP BY s.type
    ");
}

$summary = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2 class="mb-4">Laporan Total Pemesanan</h2>

    <form class="form-inline mb-3" method="GET">
        <label class="mr-2">Dari:</label>
        <input type="date" name="start" class="form-control mr-3" value="<?= $start ?>" required>

        <label class="mr-2">Sampai:</label>
        <input type="date" name="end" class="form-control mr-3" value="<?= $end ?>" required>

        <button type="submit" class="btn btn-primary mr-2">Tampilkan</button>

        <?php if ($start && $end): ?>
            <a href="export_summary.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-danger" target="_blank">Export PDF</a>
        <?php endif; ?>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Jenis Layanan</th>
                <th>Total Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($summary) === 0): ?>
                <tr><td colspan="3" class="text-center">Tidak ada data.</td></tr>
            <?php else: ?>
                <?php foreach ($summary as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= ucfirst($row['type']) ?></td>
                        <td><?= $row['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
