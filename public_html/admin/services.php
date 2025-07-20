<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

// Fungsi validasi admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';

// Ambil semua data layanan
try {
    $stmt = $pdo->query("SELECT * FROM services ORDER BY type ASC");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>❌ Gagal mengambil data layanan: " . htmlspecialchars($e->getMessage()) . "</div>";
    $services = [];
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🛠️ Daftar Jenis Layanan</h2>

    <div class="alert alert-info">
        <strong>🛈 Keterangan:</strong>
        <ul class="mb-0">
            <li><strong>Carter</strong> – Mobil + sopir (maks. 5 penumpang)</li>
            <li><strong>Pelayanan</strong> – Mobil + sopir + antar-jemput 8 jam (dalam kota)</li>
            <li><strong>Reguler</strong> – Booking kursi sesuai posisi</li>
            <li><strong>Cargo</strong> – Pengiriman barang (harga setelah konfirmasi)</li>
        </ul>
    </div>

    <?php if (!empty($services)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Layanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $index => $service): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars(ucfirst($service['type'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">Belum ada layanan yang tersedia.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
