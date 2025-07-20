<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$services = $pdo->query("SELECT id, type FROM services")->fetchAll();
$routes = $pdo->query("SELECT id, origin, destination FROM routes")->fetchAll();

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service_id = (int)($_POST['service_id'] ?? 0);
    $route_id = (int)($_POST['route_id'] ?? 0);
    $posisi = $_POST['posisi'] ?? null;
    $cargo_photo = null;

    $valid_service_ids = array_column($services, 'id');
    $valid_route_ids = array_column($routes, 'id');

    if (!in_array($service_id, $valid_service_ids) || !in_array($route_id, $valid_route_ids)) {
        die("Data tidak valid.");
    }

    if ($service_id === 4 && isset($_FILES['foto_barang']) && $_FILES['foto_barang']['error'] === 0) {
        $dir = "../uploads/barang/";
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $filename = time() . '_' . basename($_FILES["foto_barang"]["name"]);
        $cargo_photo = $dir . $filename;
        move_uploaded_file($_FILES["foto_barang"]["tmp_name"], $cargo_photo);
    }

    $harga_input = $_POST['price'] ?? '';
    $harga = is_numeric(str_replace(['Rp', '.', ','], '', $harga_input)) 
        ? (int) preg_replace('/[^\d]/', '', $harga_input) 
        : null;

    if ($harga !== null && $route_id > 0) {
        $stmt = $pdo->prepare("INSERT INTO bookings 
            (user_id, service_id, route_id, seat_position, price, cargo_photo, status, booking_date)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([$user_id, $service_id, $route_id, $posisi, $harga, $cargo_photo]);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Booking Travel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      background-color: #f4f8fb;
      font-family: 'Inter', sans-serif;
    }
    .form-container {
      max-width: 700px;
      margin: 50px auto;
      background: #ffffff;
      padding: 40px 35px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    h3 {
      font-weight: 700;
      color: #0288d1;
      margin-bottom: 30px;
    }
    .form-label {
      font-weight: 600;
      color: #37474f;
    }
    .form-control, .form-select {
      border-radius: 12px;
      padding: 12px 15px;
      font-size: 15px;
    }
    .btn-primary {
      background-color: #0288d1;
      border: none;
      border-radius: 12px;
      padding: 14px;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0277bd;
    }
    .btn-outline-secondary {
      border-radius: 12px;
      padding: 10px 20px;
    }
    .alert-success {
      border-radius: 10px;
      font-weight: 600;
      background-color: #e0f2f1;
      color: #00695c;
      border: none;
    }
    .icon-label {
      margin-right: 6px;
      color: #0288d1;
    }
  </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
  <a href="dashboard.php" class="btn btn-outline-secondary mt-4">
    <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
  </a>

  <div class="form-container">
    <h3 class="text-center"><i class="bi bi-pencil-square"></i> Formulir Pemesanan</h3>

    <?php if ($success): ?>
      <div class="alert alert-success text-center">✅ Booking berhasil!</div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label"><i class="bi bi-list-check icon-label"></i>Jenis Layanan</label>
        <select id="serviceSelect" name="service_id" class="form-select" required>
          <option value="">-- Pilih Layanan --</option>
          <?php foreach ($services as $s): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['type']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="bi bi-signpost icon-label"></i>Rute Perjalanan</label>
        <select id="routeSelect" name="route_id" class="form-select" required>
          <option value="">-- Pilih Rute --</option>
          <?php foreach ($routes as $r): ?>
            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['origin'] . ' - ' . $r['destination']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3" id="posisiGroup" style="display:none;">
        <label class="form-label"><i class="bi bi-person-seat icon-label"></i>Posisi Duduk</label>
        <select id="posisiSelect" name="posisi" class="form-select">
          <option value="">-- Pilih Posisi --</option>
          <option value="depan">Depan</option>
          <option value="tengah">Tengah</option>
          <option value="belakang">Belakang</option>
        </select>
      </div>

      <div class="mb-3" id="fotoGroup" style="display:none;">
        <label class="form-label"><i class="bi bi-camera icon-label"></i>Foto Barang (Cargo)</label>
        <input type="file" class="form-control" name="foto_barang" accept="image/*">
      </div>

      <div class="mb-3">
        <label class="form-label"><i class="bi bi-cash-stack icon-label"></i>Harga</label>
        <input type="text" id="hargaField" name="price" class="form-control" readonly>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">
          🚐 Booking Sekarang
        </button>
      </div>
    </form>
  </div>
</div>

<?php include '../includes/footer.php'; ?>

<script>
function updateUI() {
  const svc = $('#serviceSelect').val();
  $('#posisiGroup, #fotoGroup').hide();
  $('#posisiSelect').val('');
  $('#hargaField').val('');
  if (svc === '3') $('#posisiGroup').show();  // reguler
  else if (svc === '4') $('#fotoGroup').show();  // cargo
}

function fetchHarga() {
  const s = $('#serviceSelect').val();
  const r = $('#routeSelect').val();
  const p = $('#posisiSelect').val();
  if (!s || r === '') return $('#hargaField').val('');
  $.post('get_price.php', {service_id: s, route_id: r, posisi: p}, data => {
    $('#hargaField').val(data || 'Tidak ada harga');
  });
}

$(function(){
  $('#serviceSelect').change(function(){
    updateUI();
    fetchHarga();
  });
  $('#routeSelect, #posisiSelect').change(fetchHarga);
});
</script>

</body>
</html>
