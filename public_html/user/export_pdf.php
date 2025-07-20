<?php
require '../vendor/autoload.php';
require '../config/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Cek session user
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak");
}

$user_id = $_SESSION['user_id'];

// Filter opsional
$status = $_GET['status'] ?? '';
$service = $_GET['service'] ?? '';

// Query histori booking
$query = "SELECT b.booking_date, b.status, s.origin, s.destination, s.type 
          FROM bookings b
          JOIN services s ON b.service_id = s.id
          WHERE b.user_id = :user_id";

$params = ['user_id' => $user_id];

if ($status) {
    $query .= " AND b.status = :status";
    $params['status'] = $status;
}

if ($service) {
    $query .= " AND s.type = :service";
    $params['service'] = $service;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$data = $stmt->fetchAll();

// Generate HTML untuk PDF
ob_start();
?>
<h2 style="text-align:center;">Histori Booking - Travel Mobil</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead style="background-color: #f0f0f0;">
        <tr>
            <th>Tanggal</th>
            <th>Layanan</th>
            <th>Rute</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($data) === 0): ?>
            <tr>
                <td colspan="4" style="text-align:center;">Tidak ada data booking</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?= htmlspecialchars(date('d-m-Y', strtotime($d['booking_date']))) ?></td>
                    <td><?= htmlspecialchars(ucfirst($d['type'])) ?></td>
                    <td><?= htmlspecialchars($d['origin'] . ' - ' . $d['destination']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($d['status'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php
$html = ob_get_clean();

// Konfigurasi Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Kirim file ke browser
$filename = "histori_booking_" . date('Ymd_His') . ".pdf";
$dompdf->stream($filename, ["Attachment" => true]);
exit;
