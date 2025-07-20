<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: text/plain');
    require_once '../config/database.php';

    $service_id = isset($_POST['service_id']) ? (int) $_POST['service_id'] : 0;
    $route_id = isset($_POST['route_id']) ? (int) $_POST['route_id'] : 0;
    $posisi = strtolower(trim($_POST['posisi'] ?? ''));

    // Penanganan langsung untuk layanan Pelayanan (Dalam Kota)
    if ($service_id === 2 && $route_id === 0) {
        echo 'Rp 500.000';
        exit;
    }

    if ($service_id <= 0 || $route_id <= 0) {
        echo '';
        exit;
    }

    // Ambil data rute dari database
    $stmt = $pdo->prepare("SELECT origin, destination FROM routes WHERE id = ?");
    $stmt->execute([$route_id]);
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$route) {
        echo '';
        exit;
    }

    $key = strtolower($route['origin'] . '-' . $route['destination']);

    // Daftar harga Carter
    $carterPrices = [
        'bontang-sangatta' => 600000,
        'bontang-samarinda' => 650000,
        'samarinda-bontang' => 650000,
        'samarinda-balikpapan' => 750000,
        'balikpapan-samarinda' => 750000,
        'balikpapan-bontang' => 1150000,
        'bontang-balikpapan' => 1150000,
    ];

    // Daftar harga Reguler
    $regulerPrices = [
        'bontang-samarinda-depan' => 300000,
        'bontang-samarinda-tengah' => 250000,
        'bontang-samarinda-belakang' => 200000,
        'samarinda-bontang-depan' => 300000,
        'samarinda-bontang-tengah' => 250000,
        'samarinda-bontang-belakang' => 200000,
        'bontang-balikpapan-depan' => 400000,
        'bontang-balikpapan-tengah' => 350000,
        'bontang-balikpapan-belakang' => 300000,
        'samarinda-balikpapan-depan' => 350000,
        'samarinda-balikpapan-tengah' => 300000,
        'samarinda-balikpapan-belakang' => 250000,
        'balikpapan-bontang-depan' => 400000,
        'balikpapan-bontang-tengah' => 350000,
        'balikpapan-bontang-belakang' => 300000,
        'balikpapan-samarinda-depan' => 350000,
        'balikpapan-samarinda-tengah' => 300000,
        'balikpapan-samarinda-belakang' => 250000,
    ];

    // Tentukan harga
    $harga = '';

    switch ($service_id) {
        case 1: // Carter
            $harga = $carterPrices[$key] ?? '';
            break;

        case 2: // Pelayanan
            $harga = 500000;
            break;

        case 3: // Reguler
            if (!in_array($posisi, ['depan', 'tengah', 'belakang'])) {
                $harga = '';
            } else {
                $keyReguler = $key . '-' . $posisi;
                $harga = $regulerPrices[$keyReguler] ?? '';
            }
            break;

        case 4: // Cargo
            $harga = 'Akan dikonfirmasi';
            break;
    }

    echo is_numeric($harga) ? 'Rp ' . number_format($harga, 0, ',', '.') : $harga;
}
