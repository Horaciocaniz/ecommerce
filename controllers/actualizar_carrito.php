<?php
session_start();

if (!isset($_POST['cantidades'])) {
  header("Location: ../views/carrito.php");
  exit;
}

foreach ($_POST['cantidades'] as $index => $cantidad) {
  $cantidad = max(1, (int) $cantidad);
  if (isset($_SESSION['carrito'][$index])) {
    $_SESSION['carrito'][$index]['cantidad'] = $cantidad;
  }
}

header("Location: ../views/carrito.php");
exit;
