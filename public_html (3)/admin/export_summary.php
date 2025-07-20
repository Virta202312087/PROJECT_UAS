<?php
require_once '../config/database.php';
require_once '../vendor/autoload.php'; // Autoload Dompdf

use Dompdf\Dompdf;

// Ambil dan validasi parameter tanggal
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

if (!$start || !$end || !strtotime($start) || !strtotime($end)) {
    die('❌ Format tanggal tidak valid!');
}

try {
    // Ambil data pemesanan
    $stmt = $pdo->prepare("
        SELECT s.type, COUNT(b.id) AS total
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE DATE(b.booking_date) BETWEEN :start AND :end
        GROUP BY s.type
    ");
    $stmt->execute(['start' => $start, 'end' => $end]);
    $data = $stmt->fetchAll();
} catch (PDOException $e) {
    die("❌ Gagal mengambil data: " . $e->getMessage());
}

// Buat HTML laporan
ob_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        h2, p { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f8f8f8; }
    </style>
</head>
<body>
    <h2>Laporan Pemesanan per Layanan</h2>
    <p>Periode: <?= date('d-m-Y', strtotime($start)) ?> s/d <?= date('d-m-Y', strtotime($end)) ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Layanan</th>
                <th>Total Pemesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr><td colspan="3">Tidak ada data pemesanan.</td></tr>
            <?php else: ?>
                <?php $i = 1; $totalAll = 0; foreach ($data as $row): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= ucfirst(htmlspecialchars($row['type'])) ?></td>
                        <td><?= $row['total'] ?></td>
                    </tr>
                    <?php $totalAll += $row['total']; ?>
                <?php endforeach; ?>
                <tr>
                    <th colspan="2">Total Semua</th>
                    <th><?= $totalAll ?></th>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$html = ob_get_clean();

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_pemesanan_{$start}_sampai_{$end}.pdf", ["Attachment" => false]);
exit;
