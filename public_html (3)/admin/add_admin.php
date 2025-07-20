<?php
require_once '../config/database.php'; // Pastikan file ini ada dan koneksi $pdo aktif

// Data admin yang ingin ditambahkan
$username = 'admin';
$passwordPlain = 'password123';
$password = password_hash($passwordPlain, PASSWORD_DEFAULT); // Enkripsi password

// Cek apakah username sudah ada
$cek = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = ?");
$cek->execute([$username]);

if ($cek->fetchColumn() > 0) {
    echo "❌ Username '$username' sudah terdaftar. Gagal menambahkan admin baru.";
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    echo "✅ Admin '$username' berhasil ditambahkan!";
} catch (PDOException $e) {
    echo "❌ Terjadi kesalahan saat menambahkan admin: " . $e->getMessage();
}
?>
