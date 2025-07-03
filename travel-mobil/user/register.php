<?php
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    // Simpan pengguna baru
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
    $stmt->execute([
        'username' => $username,
        'password' => $password,
        'email' => $email
    ]);

    // Ambil ID user yang baru disimpan
    $user_id = $pdo->lastInsertId();

    // Simpan user_id ke session agar langsung login
    $_SESSION['user_id'] = $user_id;

    // Redirect langsung ke halaman booking
    header("Location: booking.php");
    exit();
}

include '../includes/header.php';
?>
<div class="container">
    <h1>Registrasi</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
