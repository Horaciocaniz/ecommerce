<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ecommerce/config/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ecommerce/includes/currency.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= NOMBRE_SITIO ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/estilos.css">
  <!-- CDN de Font Awesome 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Banderas para las monedas -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons/css/flag-icons.min.css">


  <link rel="icon" type="image/png" href="<?= URL_BASE ?>assets/img/logoNegro.png" sizes="32x32">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Navbar moderna con Bootstrap -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
  <div class="container">
    <!-- Marca con logo + nombre -->
    <a class="navbar-brand d-flex align-items-center fw-bold fs-4 text-primary" href="landing.php">
      <img src="<?= URL_BASE ?>assets/img/logoNegro.png" alt="Logo" width="32" height="32" class="me-2"><?= NOMBRE_SITIO ?>
    </a>

    
    
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navPrincipal">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navPrincipal">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link px-3" href="landing.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="catalogo.php">Catálogo</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="faq.php">Preguntas Frecuentes</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link px-3" href="carrito.php">Carrito</a></li>

        <li class="nav-item dropdown ms-lg-3">
        <?php $monedaActual = $monedas[$_SESSION['moneda']] ?? $monedas['GTQ']; ?>
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="monedaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="fi fi-<?= $monedaActual['flag'] ?> me-1"></span>
          <?= $_SESSION['moneda'] ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="monedaDropdown">
          <?php foreach ($monedas as $codigo => $info): ?>
            <li>
              <form method="post" action="<?= URL_BASE ?>controllers/cambiar_moneda.php" class="d-inline">
                <input type="hidden" name="moneda" value="<?= $codigo ?>">
                <button type="submit" class="dropdown-item d-flex align-items-center <?= ($_SESSION['moneda'] == $codigo ? 'active' : '') ?>">
                  <span class="fi fi-<?= $info['flag'] ?> me-2"></span>
                  <?= $info['nombre'] ?> (<?= $codigo ?>)
                </button>
              </form>
            </li>
          <?php endforeach; ?>
        </ul>
      </li>


        <li class="nav-item ms-lg-3">
          <a class="btn btn-primary rounded-pill px-4 py-2 fw-semibold" href="catalogo.php">
            Comprar ahora
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
