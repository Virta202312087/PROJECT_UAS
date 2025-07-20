<?php
session_start();
require_once '../config/database.php';
include '../includes/header.php';

// Cek autentikasi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Ambil tanggal dari parameter GET dan validasi
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

$validDateRange = ($start && $end && strtotime($start) && strtotime($end));

// Ambil data summary
try {
    if ($validDateRange) {
        $stmt = $pdo->prepare("
            SELECT s.type AS service_name, COUNT(b.id) AS total
            FROM bookings b
            JOIN services s ON b.service_id = s.id
            WHERE DATE(b.booking_date) BETWEEN :start AND :end
            GROUP BY s.type
        ");
        $stmt->execute(['start' => $start, 'end' => $end]);
    } else {
        $stmt = $pdo->query("
            SELECT s.type AS service_name, COUNT(b.id) AS total
            FROM bookings b
            JOIN services s ON b.service_id = s.id
            GROUP BY s.type
        ");
    }

    $summary = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Gagal memuat data: " . htmlspecialchars($e->getMessage()) . "</div>";
    $summary = [];
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📈 Laporan Total Pemesanan</h2>

    <form class="form-inline justify-content-center mb-4" method="GET">
        <label class="mr-2">Dari:</label>
        <input type="date" name="start" class="form-control mr-3" value="<?= htmlspecialchars($start) ?>" required>

        <label class="mr-2">Sampai:</label>
        <input type="date" name="end" class="form-control mr-3" value="<?= htmlspecialchars($end) ?>" required>

        <button type="submit" class="btn btn-primary mr-2">🔍 Tampilkan</button>

        <?php if ($validDateRange): ?>
            <a href="export_summary.php?start=<?= urlencode($start) ?>&end=<?= urlencode($end) ?>"
               class="btn btn-danger" target="_blank">
               🖨️ Export PDF
            </a>
        <?php endif; ?>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Jenis Layanan</th>
                    <th>Total Pemesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($summary)): ?>
                    <tr><td colspan="3" class="text-center text-muted">Tidak ada data pemesanan.</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($summary as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars(ucwords($row['service_name'])) ?></td>
                            <td><?= $row['total'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
