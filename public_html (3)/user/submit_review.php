<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validasi form
$booking_id = $_POST['booking_id'] ?? null;
$rating = $_POST['rating'] ?? null;
$comment = $_POST['comment'] ?? '';
$image_path = null;

if (!$booking_id || !in_array($rating, ['1','2','3','4','5'])) {
    header("Location: booking.php?review=invalid");
    exit();
}

// ✅ Pastikan booking milik user yang sedang login
$stmt = $pdo->prepare("SELECT id FROM bookings WHERE id = ? AND user_id = ?");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch();
if (!$booking) {
    header("Location: booking.php?review=unauthorized");
    exit();
}

// ✅ Upload gambar jika ada
$uploadPath = '../uploads/reviews/';
if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

if (!empty($_FILES['review_image']['name'])) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if (!in_array($_FILES['review_image']['type'], $allowedTypes)) {
        header("Location: booking.php?review=type_error");
        exit();
    }

    if ($_FILES['review_image']['size'] > $maxSize) {
        header("Location: booking.php?review=size_error");
        exit();
    }

    $imageExt = pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION);
    $imageName = uniqid('review_', true) . '.' . $imageExt;
    $image_path = $uploadPath . $imageName;
    move_uploaded_file($_FILES['review_image']['tmp_name'], $image_path);
}

// ✅ Simpan ulasan
$stmt = $pdo->prepare("INSERT INTO reviews (booking_id, rating, comment, photo, created_at)
                       VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$booking_id, $rating, $comment, $image_path]);

header("Location: booking.php?review=success");
exit();
