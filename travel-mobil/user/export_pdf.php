<?php
require '../vendor/autoload.php';
require '../config/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak");
}

$user_id = $_SESSION['user_id'];
$status = $_GET['status'] ?? '';
$service = $_GET['service'] ?? '';

// Ambil data
$query = "SELECT b.*, s.origin, s.destination, s.type FROM bookings b
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

// Bangun HTML
ob_start();
?>

<h2 style="text-align:center;">Histori Booking - Travel Mobil</h2>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Layanan</th>
            <th>Rute</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $d): ?>
            <tr>
                <td><?= $d['booking_date'] ?></td>
                <td><?= ucfirst($d['type']) ?></td>
                <td><?= $d['origin'] ?> - <?= $d['destination'] ?></td>
                <td><?= ucfirst($d['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
$html = ob_get_clean();

// PDF export
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("histori_booking.pdf", ["Attachment" => true]);
exit;
