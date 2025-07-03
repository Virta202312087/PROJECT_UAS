<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = $_POST['booking_id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$image_path = null;

$uploadPath = '../uploads/';
if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

if (!empty($_FILES['review_image']['name'])) {
    $imageName = time() . '-' . basename($_FILES['review_image']['name']);
    $image_path = $uploadPath . $imageName;
    move_uploaded_file($_FILES['review_image']['tmp_name'], $image_path);
}

$stmt = $pdo->prepare("INSERT INTO reviews (booking_id, rating, comment, image)
                       VALUES (?, ?, ?, ?)");
$stmt->execute([$booking_id, $rating, $comment, $image_path]);

header("Location: booking.php?review=success");
exit();
