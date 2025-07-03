<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Travel Mobil</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="/travel-mobil/assets/css/styles.css" />
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="/travel-mobil/index.php">
            <i class="fa-solid fa-car-side me-2"></i>Travel Mobil
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <!-- Home link -->
                <li class="nav-item">
                    <a 
                        class="nav-link <?= $current_page === 'index.php' ? 'active' : '' ?>" 
                        href="/travel-mobil/index.php"
                        <?= $current_page === 'index.php' ? 'aria-current="page"' : '' ?>
                    >Home</a>
                </li>

                <!-- Admin Panel dropdown, hanya tampil jika admin login -->
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <li class="nav-item dropdown">
                        <a 
                            class="nav-link dropdown-toggle <?= in_array($current_page, ['dashboard.php','routes.php','schedules.php','services.php','payments.php','feedback.php','reports.php','settings.php']) ? 'active' : '' ?>" 
                            href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            aria-current="<?= in_array($current_page, ['dashboard.php','routes.php','schedules.php','services.php','payments.php','feedback.php','reports.php','settings.php']) ? 'page' : 'false' ?>"
                        >
                            Admin Panel
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="/travel-mobil/admin/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/routes.php">Routes</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/schedules.php">Schedules</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/services.php">Services</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/payments.php">Payments</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/feedback.php">Feedback</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/reports.php">Reports</a></li>
                            <li><a class="dropdown-item" href="/travel-mobil/admin/settings.php">Settings</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item text-danger" href="/travel-mobil/admin/logout.php">Logout</a></li>
                        </ul>
                    </li>

                <!-- User menu -->
                <?php elseif (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'booking.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/booking.php"
                            <?= $current_page === 'booking.php' ? 'aria-current="page"' : '' ?>
                        >Booking</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'history.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/history.php"
                            <?= $current_page === 'history.php' ? 'aria-current="page"' : '' ?>
                        >Histori</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'profile.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/profile.php"
                            <?= $current_page === 'profile.php' ? 'aria-current="page"' : '' ?>
                        >Profil</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'feedback.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/feedback.php"
                            <?= $current_page === 'feedback.php' ? 'aria-current="page"' : '' ?>
                        >Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/travel-mobil/user/logout.php">Logout</a>
                    </li>

                <!-- Guest menu -->
                <?php else: ?>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'login.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/login.php"
                            <?= $current_page === 'login.php' ? 'aria-current="page"' : '' ?>
                        >Login</a>
                    </li>
                    <li class="nav-item">
                        <a 
                            class="nav-link <?= $current_page === 'register.php' ? 'active' : '' ?>" 
                            href="/travel-mobil/user/register.php"
                            <?= $current_page === 'register.php' ? 'aria-current="page"' : '' ?>
                        >Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Jangan lupa untuk menambahkan script Bootstrap JS di bagian akhir body -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
