<?php
session_start();
include_once('../includes/db.php');
include_once('../config/config.php');

if (!isset($_POST['producto_id'], $_POST['tallas']) || !is_array($_POST['tallas'])) {
  header("Location: " . URL_BASE . "views/catalogo.php");
  exit;
}

$producto_id = (int) $_POST['producto_id'];

// Iniciar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = [];
}

foreach ($_POST['tallas'] as $talla_id => $cantidad) {
  $cantidad = (int) $cantidad;
  if ($cantidad < 1) continue;

  // Obtener información del producto + talla
  $stmt = $pdo->prepare("SELECT productos.nombre, productos.precio, productos.imagen_principal, tallas.nombre AS talla
                         FROM productos 
                         JOIN producto_talla ON productos.id = producto_talla.producto_id 
                         JOIN tallas ON tallas.id = producto_talla.talla_id
                         WHERE productos.id = ? AND tallas.id = ?");
  $stmt->execute([$producto_id, $talla_id]);
  $producto = $stmt->fetch();

  if (!$producto) continue;

  // Verificar si ya está en el carrito
  $existe = false;
  foreach ($_SESSION['carrito'] as &$item) {
    if ($item['producto_id'] == $producto_id && $item['talla_id'] == $talla_id) {
      $item['cantidad'] += $cantidad;
      $existe = true;
      break;
    }
  }
  unset($item);

  if (!$existe) {
    $_SESSION['carrito'][] = [
      'producto_id' => $producto_id,
      'nombre' => $producto['nombre'],
      'precio' => $producto['precio'],
      'talla_id' => $talla_id,
      'talla' => $producto['talla'],
      'imagen' => $producto['imagen_principal'],
      'cantidad' => $cantidad
    ];
  }
}

// En lugar de redirigir inmediatamente...
echo "<script>window.location.href = '" . URL_BASE . "views/carrito.php';</script>";
exit;
