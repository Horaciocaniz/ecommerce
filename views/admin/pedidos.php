<?php
require_once __DIR__ . '/../../controllers/PedidosController.php';

// Crear el controlador
$controller = new PedidosController();

// Mostrar la lista de pedidos
$controller->index();
