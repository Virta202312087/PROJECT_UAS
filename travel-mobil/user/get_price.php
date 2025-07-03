<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'] ?? '';
    $route = $_POST['route'] ?? '';
    $posisi = $_POST['posisi'] ?? '';

    $harga = '';

    $service_id = (int)$service_id;

    if ($service_id === 1) { // Carter
        $prices = [
            'Bontang-Sangatta' => 600000,
            'Bontang-Samarinda' => 650000,
            'Samarinda-Bontang' => 650000,
            'Samarinda-Balikpapan' => 750000,
            'Balikpapan-Samarinda' => 750000,
            'Balikpapan-Bontang' => 1150000,
            'Bontang-Balikpapan' => 1150000,
        ];
        $harga = $prices[$route] ?? '';
    } elseif ($service_id === 3) { // Reguler
        $key = strtolower($route . '-' . $posisi);
        $prices = [
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
        $harga = $prices[$key] ?? '';
    } elseif ($service_id === 2) {
        $harga = 500000;
    } elseif ($service_id === 4) {
        $harga = 'Akan dikonfirmasi';
    }

    echo is_numeric($harga) ? 'Rp ' . number_format($harga, 0, ',', '.') : $harga;
}
