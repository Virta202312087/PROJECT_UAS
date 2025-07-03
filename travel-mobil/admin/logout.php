<?php
session_start();

// Hapus semua data session
session_unset();
session_destroy();

// Arahkan ke halaman depan atau halaman login admin
header("Location: ../index.php");
exit();
?>
