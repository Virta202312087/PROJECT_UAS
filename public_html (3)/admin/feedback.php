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

<?php include '../includes/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">📬 Feedback dari Pengguna</h2>

    <?php if (count($feedbacks) === 0): ?>
        <div class="alert alert-info text-center">Belum ada feedback dari pengguna.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($feedbacks as $f): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($f['name']) ?></strong> 
                    <span class="text-muted float-right">
                        <?= date('d M Y, H:i', strtotime($f['created_at'])) ?>
                    </span>
                    <p class="mb-1 mt-2"><?= nl2br(htmlspecialchars($f['message'])) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
