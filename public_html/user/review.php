<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['booking_id'] ?? null;
$success = false;

if (!$booking_id) {
    echo "Booking ID tidak ditemukan.";
    exit();
}

// Cek apakah booking milik user
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $booking_id, 'user_id' => $user_id]);
$booking = $stmt->fetch();

if (!$booking) {
    echo "Booking tidak valid atau tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';
    $photo_path = null;

    // Validasi rating
    if (!in_array($rating, ['1','2','3','4','5'])) {
        echo "Rating tidak valid.";
        exit();
    }

    $uploadPath = '../uploads/reviews/';
    if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

    if (!empty($_FILES['photo']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
            echo "Format foto tidak didukung.";
            exit();
        }

        if ($_FILES['photo']['size'] > $maxSize) {
            echo "Ukuran foto terlalu besar (maksimal 2MB).";
            exit();
        }

        $photoName = uniqid('review_', true) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_path = $uploadPath . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }

    $stmt = $pdo->prepare("INSERT INTO reviews (booking_id, rating, comment, photo, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$booking_id, $rating, $comment, $photo_path]);

    $success = true;
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

    <?php if ($success): ?>
        <div class="alert alert-success">✅ Terima kasih atas ulasan Anda!</div>
    <?php endif; ?>

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
            <small class="form-text text-muted">Hanya JPG, PNG, atau WebP (maks 2MB)</small>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>

    <!-- 🔙 Tombol Kembali ke Dashboard -->
    <a href="dashboard.php" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a>
</div>
</body>
</html>
