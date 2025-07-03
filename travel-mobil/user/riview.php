<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    echo "Booking ID tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';
    $photo_path = null;

    $uploadPath = '../uploads/reviews/';
    if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . '-' . basename($_FILES['photo']['name']);
        $photo_path = $uploadPath . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }

    $stmt = $pdo->prepare("INSERT INTO reviews (booking_id, rating, comment, photo, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$booking_id, $rating, $comment, $photo_path]);

    echo "<div style='padding:20px; background:#d4edda;'>Terima kasih atas ulasan Anda!</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beri Ulasan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Ulasan untuk Booking #<?= htmlspecialchars($booking_id) ?></h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Rating</label>
            <select name="rating" class="form-control" required>
                <option value="">-- Pilih Rating --</option>
                <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                <option value="4">⭐⭐⭐⭐ Baik</option>
                <option value="3">⭐⭐⭐ Cukup</option>
                <option value="2">⭐⭐ Kurang</option>
                <option value="1">⭐ Buruk</option>
            </select>
        </div>
        <div class="form-group">
            <label>Komentar</label>
            <textarea name="comment" class="form-control" rows="4" placeholder="Tuliskan pengalaman Anda..."></textarea>
        </div>
        <div class="form-group">
            <label>Upload Foto (opsional)</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>
</div>
</body>
</html>
