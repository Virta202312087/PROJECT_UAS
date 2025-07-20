<?php
$host = 'localhost';
$db   = 'u722095453_travel_mobil';
$user = 'u722095453_travel_user';
$pass = 'Untung120604#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
