<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil daftar layanan
$services = [
    ['id' => 1, 'name' => 'Carter', 'price' => null],
    ['id' => 2, 'name' => 'Pelayanan', 'price' => 500000],
    ['id' => 3, 'name' => 'Reguler', 'price' => null],
    ['id' => 4, 'name' => 'Cargo', 'price' => null]
];

// Proses form booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = $_POST['service_id'] ?? null;
    $route = $_POST['route'] ?? '';
    $tanggal = $_POST['tanggal'] ?? null;
    $jam = $_POST['jam'] ?? null;
    $posisi = $_POST['posisi'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, service_id, route, posisi_duduk, tanggal, jam, status, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$user_id, $service_id, $route, $posisi, $tanggal, $jam]);

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Form Booking</h3>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Booking berhasil dikirim!</div>
    <?php endif; ?>

    <form method="POST">
        <!-- Jenis Layanan -->
        <div class="form-group">
            <label>Jenis Layanan</label>
            <select name="service_id" class="form-control" required id="serviceSelect">
                <option value="">-- Pilih Layanan --</option>
                <?php foreach ($services as $s): ?>
                    <option value="<?= $s['id'] ?>" data-price="<?= $s['price'] ?>">
                        <?= $s['name'] ?> <?= $s['price'] !== null ? '- Rp ' . number_format($s['price'], 0, ',', '.') : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small id="priceLabel" class="form-text text-muted mt-1"></small>
        </div>

        <!-- Rute -->
        <div class="form-group">
            <label>Rute</label>
            <select name="route" class="form-control" required>
                <option value="">-- Pilih Rute --</option>
                <option value="Bontang-Sangatta">Bontang - Sangatta</option>
                <option value="Bontang-Samarinda">Bontang - Samarinda</option>
                <option value="Samarinda-Bontang">Samarinda - Bontang</option>
                <option value="Bontang-Balikpapan">Bontang - Balikpapan</option>
                <option value="Balikpapan-Bontang">Balikpapan - Bontang</option>
                <option value="Samarinda-Balikpapan">Samarinda - Balikpapan</option>
                <option value="Balikpapan-Samarinda">Balikpapan - Samarinda</option>
            </select>
        </div>

        <!-- Posisi Duduk -->
        <div class="form-group" id="posisiGroup" style="display:none;">
            <label>Posisi Duduk</label>
            <select name="posisi" class="form-control" id="posisiSelect">
                <option value="">-- Pilih Posisi --</option>
                <option value="depan">Depan</option>
                <option value="tengah">Tengah</option>
                <option value="belakang">Belakang</option>
            </select>
        </div>

        <!-- Jadwal (Tanggal & Jam Penjemputan) -->
        <div class="form-group">
            <label for="tanggal">Tanggal Penjemputan</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jam">Jam Penjemputan</label>
            <input type="time" name="jam" id="jam" class="form-control" required>
        </div>

        <!-- Harga -->
        <div class="form-group">
            <label>Harga</label>
            <input type="text" class="form-control" id="hargaField" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Booking Sekarang</button>
    </form>
</div>

<!-- Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateHarga() {
    const service_id = $('#serviceSelect').val();
    const route = $('select[name="route"]').val();
    const posisi = $('#posisiSelect').val();

    if (!service_id || !route) return;

    $.post('get_price.php', {
        service_id: service_id,
        route: route,
        posisi: posisi
    }, function (data) {
        $('#hargaField').val(data);
    });
}

// Tampilkan posisi hanya untuk layanan Reguler
$('#serviceSelect').on('change', function () {
    const selected = $(this).val();
    const label = document.getElementById('priceLabel');
    label.textContent = '';

    if (selected === '3') {
        $('#posisiGroup').show();
    } else {
        $('#posisiGroup').hide();
        $('#posisiSelect').val('');
    }

    updateHarga();
});

$('#posisiSelect, select[name="route"]').on('change', updateHarga);

// Auto fokus ke jam setelah pilih tanggal
document.getElementById('tanggal').addEventListener('change', function () {
    document.getElementById('jam').focus();
});

// Batasi tanggal minimal hari ini
document.getElementById('tanggal').min = new Date().toISOString().split("T")[0];
</script>
</body>
</html>
