<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Mobil</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- 🔷 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/index.php">
      <i class="fa-solid fa-car-side me-2"></i>Travel Mobil
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['admin_id'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= in_array($current_page, [
              'dashboard.php', 'routes.php', 'schedules.php', 'services.php',
              'payments.php', 'feedback.php', 'reports.php', 'settings.php', 'prices.php'
            ]) ? 'active' : '' ?>" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
              Admin Panel
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
              <li><a class="dropdown-item" href="/admin/dashboard.php">Dashboard</a></li>
              <li><a class="dropdown-item" href="/admin/routes.php">Routes</a></li>
              <li><a class="dropdown-item" href="/admin/schedules.php">Schedules</a></li>
              <li><a class="dropdown-item" href="/admin/services.php">Services</a></li>
              <li><a class="dropdown-item" href="/admin/prices.php">Prices</a></li>
              <li><a class="dropdown-item" href="/admin/payments.php">Payments</a></li>
              <li><a class="dropdown-item" href="/admin/feedback.php">Feedback</a></li>
              <li><a class="dropdown-item" href="/admin/reports.php">Reports</a></li>
              <li><a class="dropdown-item" href="/admin/settings.php">Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="/admin/logout.php">Logout</a></li>
            </ul>
          </li>

        <?php elseif (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'booking.php' ? 'active' : '' ?>" href="/user/booking.php">Booking</a></li>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'history.php' ? 'active' : '' ?>" href="/user/history.php">Histori</a></li>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'profile.php' ? 'active' : '' ?>" href="/user/profile.php">Profil</a></li>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'feedback.php' ? 'active' : '' ?>" href="/user/feedback.php">Feedback</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="/user/logout.php">Logout</a></li>

        <?php else: ?>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'login.php' ? 'active' : '' ?>" href="/user/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link <?= $current_page === 'register.php' ? 'active' : '' ?>" href="/user/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
