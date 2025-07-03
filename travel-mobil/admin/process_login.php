<?php
session_start();
require_once '../config/database.php'; // Pastikan ini mengarah ke file database.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Siapkan dan eksekusi query menggunakan PDO
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    // Verifikasi password
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: index.php"); // Ganti ke dashboard.php jika ada
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>