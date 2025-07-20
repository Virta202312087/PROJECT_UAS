<?php
session_start();
require_once '../config/database.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data layanan dan rute
$services = $pdo->query("SELECT id, type FROM services")->fetchAll(PDO::FETCH_ASSOC);
$routes = $pdo->query("SELECT id, origin, destination FROM routes")->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi pesan
$message = "";

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = (int) ($_POST['service_id'] ?? 0);
    $route_id = (int) ($_POST['route_id'] ?? 0);
    $posisi = ($_POST['posisi'] !== '') ? $_POST['posisi'] : null;
    $price = (int) ($_POST['price'] ?? 0);

    if ($service_id && $route_id && $price > 0) {
        // Cek apakah kombinasi sudah ada
        $stmt = $pdo->prepare("SELECT id FROM prices WHERE service_id = ? AND route_id = ? AND posisi <=> ?");
        $stmt->execute([$service_id, $route_id, $posisi]);

        if ($stmt->fetch()) {
            $update = $pdo->prepare("UPDATE prices SET price = ? WHERE service_id = ? AND route_id = ? AND posisi <=> ?");
            $update->execute([$price, $service_id, $route_id, $posisi]);
        } else {
            $insert = $pdo->prepare("INSERT INTO prices (service_id, route_id, posisi, price) VALUES (?, ?, ?, ?)");
            $insert->execute([$service_id, $route_id, $posisi, $price]);
        }

        $message = "✅ Harga berhasil disimpan atau diperbarui.";
    } else {
        $message = "⚠️ Pastikan semua data terisi dengan benar.";
    }
}

// Ambil semua harga
$allPrices = $pdo->query("
    SELECT p.*, s.type AS service_name, r.origin, r.destination
    FROM prices p
    JOIN services s ON s.id = p.service_id
    JOIN routes r ON r.id = p.route_id
    ORDER BY s.type ASC, r.origin ASC, p.posisi ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Harga Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 920px;
        }
        h3 {
            color: #00796b;
            font-weight: 700;
        }
        .btn-primary {
            background-color: #00796b;
            border: none;
        }
        .btn-primary:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; // Navbar admin ?>

<div class="container my-5">
    <h3 class="mb-4 text-center">💰 Kelola Harga Layanan</h3>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <div class="card shadow p-4 mb-4">
        <form method="POST">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Layanan</label>
                    <select name="service_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($services as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['type']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rute</label>
                    <select name="route_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($routes as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['origin']) ?> - <?= htmlspecialchars($r['destination']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Posisi</label>
                    <select name="posisi" class="form-select">
                        <option value="">(Kosong untuk Carter/Cargo)</option>
                        <option value="depan">Depan</option>
                        <option value="tengah">Tengah</option>
                        <option value="belakang">Belakang</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow p-4">
        <h5 class="mb-3">📋 Daftar Harga Tersimpan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                <tr>
                    <th>Layanan</th>
                    <th>Rute</th>
                    <th>Posisi</th>
                    <th>Harga</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($allPrices): ?>
                    <?php foreach ($allPrices as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['service_name']) ?></td>
                            <td><?= htmlspecialchars($p['origin'] . ' - ' . $p['destination']) ?></td>
                            <td><?= $p['posisi'] ? ucfirst($p['posisi']) : '-' ?></td>
                            <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Belum ada data harga.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; // Footer ?>
</body>
</html>
