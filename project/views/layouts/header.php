<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($pageTitle ?? 'Sistem Akademik MVC'); ?></title>

  <!-- Bootstrap 5 CSS Lokal -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <!-- Bilah Navigasi Utama -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php?page=lecturers&action=index">Academic MVC</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?php echo ($activeMenu ?? '') === 'lecturers' ? 'active fw-semibold' : ''; ?>"
               href="index.php?page=lecturers&action=index">Lecturers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activeMenu ?? '') === 'departments' ? 'active fw-semibold' : ''; ?>"
               href="index.php?page=departments&action=index">Departments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($activeMenu ?? '') === 'courses' ? 'active fw-semibold' : ''; ?>"
               href="index.php?page=courses&action=index">Courses</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Kontainer Utama -->
  <div class="container my-4">
    <?php if (isset($_SESSION['flash'])): ?>
      <div class="alert alert-<?php echo htmlspecialchars($_SESSION['flash']['type']); ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['flash']['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
