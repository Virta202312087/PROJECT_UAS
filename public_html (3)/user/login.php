<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            unset($_SESSION['admin_id']);
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Email atau password salah.";
        }
    } else {
        $error = "Harap isi semua field.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pengguna - Travel Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font dan CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #E3F2FD, #ffffff);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.8s ease;
        }

        h4 {
            color: #0D47A1;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .btn-primary {
            background-color: #00ACC1;
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 12px;
        }

        .btn-primary:hover {
            background-color: #0097A7;
        }

        .text-muted a {
            color: #0D47A1;
            text-decoration: none;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }

        .back-btn {
            font-size: 0.9rem;
            color: #616161;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="login-box">
    <h4 class="text-center">🔐 Login Pengguna</h4>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Masuk Sekarang</button>
        </div>
    </form>

    <p class="text-center mt-3 text-muted">
        Belum punya akun? <a href="register.php"><strong>Daftar di sini</strong></a>
    </p>

    <div class="text-center mt-2">
        <a href="dashboard.php" class="back-btn">← Kembali ke Halaman Utama</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
