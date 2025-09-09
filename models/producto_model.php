<?php
include_once(__DIR__ . '/../config/config.php');
include_once(__DIR__ . '/../includes/db.php');



function obtenerProductos($pdo) {
  $stmt = $pdo->query("
    SELECT p.*, c.nombre AS categoria, pa.nombre AS pais
    FROM productos p
    LEFT JOIN categorias c ON p.categoria_id = c.id
    LEFT JOIN paises pa ON p.pais_id = pa.id
    ORDER BY p.fecha_creacion DESC
  ");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProductoPorId($pdo, $id) {
  $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
  $stmt->execute([$id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function crearProducto($pdo, $data) {
  $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, categoria_id, pais_id, imagen_principal) VALUES (?, ?, ?, ?, ?, ?)");
  return $stmt->execute([
    $data['nombre'],
    $data['descripcion'],
    $data['precio'],
    $data['categoria_id'],
    $data['pais_id'],
    $data['imagen_principal']
  ]);
}

function actualizarProducto($pdo, $data) {
  $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, pais_id = ?, imagen_principal = ? WHERE id = ?");
  return $stmt->execute([
    $data['nombre'],
    $data['descripcion'],
    $data['precio'],
    $data['categoria_id'],
    $data['pais_id'],
    $data['imagen_principal'],
    $data['id']
  ]);
}

function eliminarProducto($pdo, $id) {
  $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
  return $stmt->execute([$id]);
}
?>
