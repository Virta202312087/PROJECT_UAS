<?php
session_start();
require_once '../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($password) || empty($email)) {
        $errors[] = "Semua kolom wajib diisi.";
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $check->execute(['email' => $email]);
        $exists = $check->fetchColumn();

        if ($exists > 0) {
            $errors[] = "Email sudah terdaftar.";
        }
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, password, email) VALUES (:name, :password, :email)");
        $stmt->execute([
            'name' => $name,
            'password' => $hashed,
            'email' => $email
        ]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $name;
        header("Location: booking.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun - Travel Mobil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font & Bootstrap -->
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
            padding: 2rem;
        }

        .register-box {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.8s ease;
        }

        h1 {
            color: #0D47A1;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #333;
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

        .text-link a {
            color: #0D47A1;
            text-decoration: none;
        }

        .text-link a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="register-box">
    <h1>Daftar Akun</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="password">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="email">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
        </div>
    </form>

    <p class="mt-3 text-center text-link">
        Sudah punya akun? <a href="login.php"><strong>Login di sini</strong></a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
