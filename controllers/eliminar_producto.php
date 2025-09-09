<?php
require_once '../includes/db.php';

// Validar ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID de producto no proporcionado');
}

// Eliminar tallas asociadas (si usas integridad referencial en DB esto puede ser automático)
$sqlTallas = "DELETE FROM producto_talla WHERE producto_id = ?";
$stmtTallas = $pdo->prepare($sqlTallas);
$stmtTallas->execute([$id]);

// Eliminar producto
$sqlProducto = "DELETE FROM productos WHERE id = ?";
$stmtProducto = $pdo->prepare($sqlProducto);
$stmtProducto->execute([$id]);

// Redirigir
header('Location: ../views/admin/productos/index.php?eliminado=1');
exit;
