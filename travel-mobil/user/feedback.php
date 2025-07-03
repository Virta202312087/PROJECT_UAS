<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$feedbacks = $pdo->query("SELECT f.message, f.created_at, u.name 
    FROM feedback f
    JOIN users u ON f.user_id = u.id
    ORDER BY f.created_at DESC")->fetchAll();
?>

<?php include 'partials/header.php'; ?>
<div class="container mt-4">
    <h2>Feedback Pengguna</h2>
    <?php if (count($feedbacks) === 0): ?>
        <div class="alert alert-info">Belum ada feedback.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($feedbacks as $f): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($f['name']) ?>:</strong>
                    <p><?= nl2br(htmlspecialchars($f['message'])) ?></p>
                    <small class="text-muted"><?= $f['created_at'] ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php include 'partials/footer.php'; ?>
