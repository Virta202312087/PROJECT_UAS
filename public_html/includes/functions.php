<?php
// Pastikan session dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cek apakah user sudah login sebagai pengguna biasa.
 *
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Cek apakah user login sebagai admin.
 *
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

/**
 * Cek apakah user login sebagai user (bukan admin).
 *
 * @return bool
 */
function isUser() {
    return isset($_SESSION['user_id']) && !isset($_SESSION['admin_id']);
}
?>
