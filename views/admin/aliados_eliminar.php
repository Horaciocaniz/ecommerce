<?php
require_once __DIR__ . '/../../controllers/AliadosController.php';
$controller = new AliadosController();
$controller->eliminar($_GET['id'] ?? 0);
?>
