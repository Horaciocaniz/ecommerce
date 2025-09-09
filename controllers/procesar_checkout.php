<?php
session_start();
require_once __DIR__ . '/../config/config.php';

if (
  empty($_POST['nombre']) ||
  empty($_POST['correo']) ||
  empty($_POST['telefono']) ||
  empty($_POST['direccion']) ||
  empty($_SESSION['carrito'])
) {
  header("Location: ../views/checkout.php");
  exit;
}

// Guardamos TODO en sesión para usarlo en pago_tarjeta y luego en éxito
$_SESSION['checkout_data'] = [
  'nombre'     => strip_tags(trim($_POST['nombre'])),
  'correo'     => strip_tags(trim($_POST['correo'])),
  'telefono'   => strip_tags(trim($_POST['telefono'])),
  'direccion'  => strip_tags(trim($_POST['direccion'])),
  'comentario' => !empty($_POST['comentario']) ? strip_tags(trim($_POST['comentario'])) : null,
  'carrito'    => $_SESSION['carrito']    // aquí tienes producto_id, talla_id, cantidad, precio, nombre, imagen, etc.
];

// Redirige a tu creador del link (lo dejamos con el mismo nombre)
header("Location: pago_tarjeta.php");
exit;
