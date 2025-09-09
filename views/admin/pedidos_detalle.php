<?php
require_once __DIR__ . '/../../controllers/PedidosController.php';
$controller = new PedidosController();
$id = $_GET['id'] ?? null;
if ($id) {
    $controller->detalle($id);
} else {
    header("Location: pedidos.php");
}
