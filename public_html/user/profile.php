<?php
session_start();

// Fungsi untuk mengecek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';
include '../includes/header.php';

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

// Validasi jika user tidak ditemukan
if (!$user) {
    echo "<div class='container mt-5 alert alert-danger'>Pengguna tidak ditemukan.</div>";
    include '../includes/footer.php';
    exit();
}
?>

<!-- Tambahkan Font & Styling ala Traveloka -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f2f6fc;
        color: #333;
    }

    .profile-container {
        max-width: 600px;
        margin: 60px auto;
        background-color: #ffffff;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.05);
    }

    h1 {
        font-weight: 700;
        color: #0288d1;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-group label {
        font-weight: 600;
        color: #555;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #ccc;
        box-shadow: none;
    }

    .form-control:focus {
        border-color: #0288d1;
        box-shadow: 0 0 0 0.15rem rgba(2, 136, 209, 0.25);
    }

    .btn-primary {
        background-color: #0288d1;
        border-color: #0288d1;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0277bd;
    }

    .btn-outline-secondary {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
        display: block;
        margin-top: 20px;
        text-align: center;
        width: 100%;
    }

    @media (max-width: 576px) {
        .profile-container {
            padding: 30px 20px;
        }
    }
</style>

<div class="profile-container">
    <h1>Profil Pengguna</h1>
    <form action="update_profile.php" method="POST">
        <div class="form-group mb-3">
            <label for="name">Nama Lengkap:</label>
            <input type="text" name="name" class="form-control" id="name"
                   value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email"
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
    </form>

    <!-- 🔙 Tombol kembali ke dashboard -->
    <a href="dashboard.php" class="btn btn-outline-secondary">
        ← Kembali ke Dashboard
    </a>
</div>

<?php include '../includes/footer.php'; ?>
