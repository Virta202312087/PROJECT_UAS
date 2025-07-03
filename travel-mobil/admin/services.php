<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';
include '../includes/header.php';
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Layanan Travel</h2>

    <div class="alert alert-info">
        <strong>Keterangan Jenis Layanan:</strong>
        <ul>
            <li><strong>Carter</strong> – Booking mobil + driver (maks. 5 orang)</li>
            <li><strong>Pelayanan</strong> – Booking mobil + driver + antar-jemput selama 8 jam (dalam kota)</li>
            <li><strong>Reguler</strong> – Booking kursi sesuai posisi duduk</li>
            <li><strong>Cargo</strong> – Jasa antar barang/dokumen (harga dikonfirmasi setelah upload foto)</li>
        </ul>
    </div>

    <?php
    $stmt = $pdo->query("SELECT * FROM services ORDER BY type, origin, destination");
    $services = $stmt->fetchAll();
    ?>

    <?php if (count($services) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Jenis Layanan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $index => $service): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($service['origin']) ?></td>
                            <td><?= htmlspecialchars($service['destination']) ?></td>
                            <td><?= ucwords($service['type']) ?></td>
                            <td>
                                <?= $service['price'] > 0 
                                    ? 'Rp ' . number_format($service['price'], 0, ',', '.') 
                                    : '<em>Akan dikonfirmasi</em>' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Belum ada layanan tersedia.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
