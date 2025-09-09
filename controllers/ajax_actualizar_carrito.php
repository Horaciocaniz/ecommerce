<?php
session_start();

if (!isset($_POST['index']) || !isset($_POST['cantidad'])) {
  echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
  exit;
}

$index = (int) $_POST['index'];
$cantidad = max(1, (int) $_POST['cantidad']);

if (isset($_SESSION['carrito'][$index])) {
  $_SESSION['carrito'][$index]['cantidad'] = $cantidad;

  $precio = $_SESSION['carrito'][$index]['precio'];
  $subtotal = $cantidad * $precio;

  $total = 0;
  foreach ($_SESSION['carrito'] as $item) {
    $total += $item['cantidad'] * $item['precio'];
  }

  echo json_encode([
    'success' => true,
    'subtotal' => number_format($subtotal, 2),
    'total' => number_format($total, 2)
  ]);
  exit;
}

echo json_encode(['success' => false, 'message' => 'Ítem no encontrado']);
