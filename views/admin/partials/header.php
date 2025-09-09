<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ecommerce/includes/auth_admin.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ecommerce/config/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin | <?= NOMBRE_SITIO ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/ecommerce/assets/css/admin.css">
  <link rel="icon" type="image/png" href="<?= URL_BASE ?>assets/img/logoNegro.png">

  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="<?= ADMIN_URL ?>dashboard.php"><?= NOMBRE_SITIO ?> Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>productos/index.php"><i class="fas fa-boxes"></i> Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>pedidos.php"><i class="fas fa-receipt"></i> Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>categorias.php"><i class="fas fa-tags"></i> Categorías</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>paises.php"><i class="fa-solid fa-earth-americas"></i> Paises</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>aliados.php"><i class="fa-regular fa-handshake"></i> Aliados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= ADMIN_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
