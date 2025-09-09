<?php
require_once __DIR__ . '/../../controllers/AliadosController.php';
$controller = new AliadosController();
$controller->editar($_GET['id'] ?? 0);
?>
