<?php
session_start();

// ✅ Tambahkan fungsi ini
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
include '../config/database.php';

// Ambil data pengguna
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();
?>
<div class="container mt-5">
    <h1>Profil Pengguna</h1>
    <form action="update_profile.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
