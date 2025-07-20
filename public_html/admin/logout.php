<?php
session_start();

// Hapus semua data session
$_SESSION = [];           // Kosongkan array session
session_unset();          // Hapus semua variabel session
session_destroy();        // Hancurkan session

// Tambahan: Hapus cookie session (jika ada)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman utama atau login
header("Location: ../index.php");
exit();
?>
