<?php
// Memanggil bagian atas HTML dan navigasi
include 'includes/header.php';
?>

<!-- Google Font Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #E3F2FD, #ffffff);
        background-attachment: fixed;
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main-box {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        padding: 3rem 2rem;
        max-width: 700px;
        width: 100%;
        animation: fadeIn 1s ease-in-out;
    }

    h1 {
        font-weight: 700;
        color: #0D47A1;
        margin-bottom: 10px;
    }

    p.lead {
        color: #555;
        font-size: 1.15rem;
        margin-bottom: 2.5rem;
    }

    .btn-role {
        display: block;
        padding: 1rem;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.05rem;
        text-align: left;
        background: #ffffff;
        transition: all 0.3s ease;
        border: 2px solid #e0e0e0;
    }

    .btn-role:hover {
        background: linear-gradient(to right, #E0F7FA, #ffffff);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        transform: scale(1.02);
        border-color: #00ACC1;
    }

    .btn-role i {
        font-size: 1.5rem;
        margin-right: 10px;
        vertical-align: middle;
    }

    .btn-back {
        margin-top: 2rem;
        background-color: #ECEFF1;
        color: #333;
    }

    .btn-back:hover {
        background-color: #CFD8DC;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container">
    <div class="main-box text-center">
        <h1>Selamat Datang</h1>
        <p class="lead">🚐 Pilih peran Anda untuk mulai menggunakan layanan kami</p>

        <div class="row g-3 justify-content-center">
            <div class="col-12 col-md-6">
                <a href="/user/login.php" class="btn-role w-100 shadow-sm">
                    <i class="bi bi-person-circle text-primary"></i> Masuk sebagai <strong>Customer</strong>
                </a>
            </div>
            <div class="col-12 col-md-6">
                <a href="/admin/login.php" class="btn-role w-100 shadow-sm">
                    <i class="bi bi-shield-lock-fill text-success"></i> Masuk sebagai <strong>Admin</strong>
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 col-md-6">
                <button onclick="window.history.back();" class="btn btn-back w-100 btn-lg shadow-sm mt-4 rounded">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                </button>
            </div>
        </div>
    </div>
</div>

<?php
// Memanggil bagian bawah HTML dan penutup
include 'includes/footer.php';
?>
