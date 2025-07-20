<?php
session_start();
require_once '../config/database.php'; // Pastikan koneksi PDO tersambung ($pdo)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=1");
        exit();
    }

    try {
        // Cek ke tabel users, khusus role admin
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role = 'admin' LIMIT 1");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: index.php"); // Ubah ke dashboard.php jika perlu
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        header("Location: login.php?error=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
