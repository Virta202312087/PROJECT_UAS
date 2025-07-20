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

$allowed_status = ['pending', 'confirmed', 'cancelled'];
$allowed_type = ['carter', 'reguler', 'pelayanan', 'cargo'];

if ($status_filter !== '' && !in_array($status_filter, $allowed_status)) {
    $status_filter = '';
}
if ($type_filter !== '' && !in_array(strtolower($type_filter), $allowed_type)) {
    $type_filter = '';
}

// Query booking
$query = "SELECT b.*, s.type AS service_name, r.origin, r.destination
          FROM bookings b
          JOIN services s ON b.service_id = s.id
          LEFT JOIN routes r ON b.route_id = r.id
          WHERE b.user_id = :user_id";
$params = ['user_id' => $_SESSION['user_id']];

if ($status_filter !== '') {
    $query .= " AND b.status = :status";
    $params['status'] = $status_filter;
}
if ($type_filter !== '') {
    $query .= " AND s.type = :type";
    $params['type'] = strtolower($type_filter);
}

$query .= " ORDER BY b.booking_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$bookings = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<!-- Tambahkan font Inter -->
<!-- Font dan Icon -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f2f6fc;
        color: #333;
    }

    .container {
        margin-top: 60px;
        margin-bottom: 60px;
    }

    h2 {
        font-weight: 700;
        color: #0288d1;
    }

    .btn-primary {
        background-color: #0288d1;
        border-color: #0288d1;
    }

    .btn-primary:hover {
        background-color: #0277bd;
    }

    .btn-danger {
        font-weight: 600;
    }

    .form-inline label {
        margin-right: 8px;
        font-weight: 600;
    }

    .form-inline .form-control {
        margin-right: 12px;
        min-width: 160px;
        border-radius: 10px;
        box-shadow: none;
        border: 1px solid #ccc;
    }

    .table {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .table th {
        background-color: #0288d1;
        color: #fff;
        font-weight: 600;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        background-color: #ffffff;
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover td {
        background-color: #f1faff;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.85rem;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-secondary {
        background-color: #e2e3e5;
        color: #383d41;
    }

    a.btn-secondary {
        background-color: #eceff1;
        color: #37474f;
        border: none;
        font-weight: 600;
    }

    a.btn-secondary:hover {
        background-color: #cfd8dc;
    }

    a {
        text-decoration: none;
    }

    .text-muted {
        font-size: 0.9rem;
        color: #888 !important;
    }
</style>

<div class="container">
    <h2 class="mb-4">📜 Histori Booking Anda</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Kembali ke Dashboard</a>

    <form class="form-inline mb-4 d-flex flex-wrap align-items-center" method="GET">
        <label>Status:</label>
        <select name="status" class="form-control">
            <option value="">Semua</option>
            <?php foreach ($allowed_status as $status): ?>
                <option value="<?= $status ?>" <?= $status_filter === $status ? 'selected' : '' ?>>
                    <?= ucfirst($status) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Layanan:</label>
        <select name="type" class="form-control">
            <option value="">Semua</option>
            <?php foreach ($allowed_type as $type): ?>
                <option value="<?= $type ?>" <?= strtolower($type_filter) === $type ? 'selected' : '' ?>>
                    <?= ucfirst($type) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary me-2">🔍 Filter</button>
        <a href="export_pdf.php?status=<?= urlencode($status_filter) ?>&service=<?= urlencode($type_filter) ?>" class="btn btn-danger" target="_blank">📄 Export PDF</a>
    </form>

    <table class="table table-striped table-hover text-center">
        <thead>
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
            <tr><td colspan="8" class="text-muted">Tidak ada data booking ditemukan.</td></tr>
        <?php else: ?>
            <?php foreach ($bookings as $index => $b): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars(ucfirst($b['service_name'])) ?></td>
                    <td>
                        <?= $b['origin'] && $b['destination']
                            ? htmlspecialchars($b['origin']) . ' - ' . htmlspecialchars($b['destination'])
                            : '<span class="text-muted">-</span>' ?>
                    </td>
                    <td><?= date('d-m-Y H:i', strtotime($b['booking_date'])) ?></td>
                    <td>
                        <span class="badge badge-<?= $b['status'] === 'pending' ? 'warning' : ($b['status'] === 'confirmed' ? 'success' : 'secondary') ?>">
                            <?= ucfirst(htmlspecialchars($b['status'])) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($b['seat_position'] ?? '-') ?></td>
                    <td>
                        <?php if (!empty($b['transfer_proof'])): ?>
                            <a href="<?= htmlspecialchars($b['transfer_proof']) ?>" target="_blank">📷 Lihat</a>
                        <?php else: ?>
                            <span class="text-muted">Belum ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($b['foto_barang'])): ?>
                            <a href="<?= htmlspecialchars($b['foto_barang']) ?>" target="_blank">📦 Lihat</a>
                        <?php else: ?>
                            <span class="text-muted">Belum ada</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
