<?php
include_once(__DIR__ . '/../config/config.php'); // Sube a /config/
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= NOMBRE_SITIO ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap y FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Banderas para las monedas -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">

  <!-- Estilos globales -->
  <link rel="stylesheet" href="<?= URL_BASE ?>assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/landing.css">
  <link rel="icon" type="image/png" href="<?= URL_BASE ?>assets/img/logoNegro.png" sizes="32x32">


</head>
<body>

<!-- Navbar pública -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= URL_BASE ?>index.php"><?= NOMBRE_SITIO ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= URL_BASE ?>index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL_BASE ?>productos/index.php">Catálogo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL_BASE ?>faq.php">Preguntas Frecuentes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL_BASE ?>contacto.php">Contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL_BASE ?>carrito.php">
            <i class="fas fa-shopping-cart"></i> Carrito
          </a>
        </li>
        

      </ul>
    </div>
  </div>
</nav>

<div class="container py-4">
