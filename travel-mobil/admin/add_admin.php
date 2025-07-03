<?php
require_once '../config/database.php'; // Pastikan untuk mengimpor koneksi database

// Username dan password yang ingin ditambahkan
$username = 'admin';
$password = password_hash('password123', PASSWORD_DEFAULT); // Enkripsi password

// Query untuk menambahkan admin ke tabel
$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin berhasil ditambahkan!";
?>
