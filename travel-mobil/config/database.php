<?php
$host = 'localhost';
$db   = 'travel_mobil';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lempar error sebagai Exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch default: associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Gunakan prepared statement asli
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit("Koneksi database gagal: " . $e->getMessage());
}
?>
