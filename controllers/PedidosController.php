<?php
require_once __DIR__ . '/../models/PedidoModel.php';

class PedidosController {
    private $model;

    public function __construct() {
        $this->model = new PedidoModel();
    }

    // Muestra la lista de pedidos
    public function index() {
        $pedidos = $this->model->obtenerTodos();
        require __DIR__ . '/../views/admin/pedidos/index.php';
    }

    // Muestra el detalle de un pedido
    public function detalle($id) {
        $pedido = $this->model->obtenerPorId($id);
        $detalle = $this->model->obtenerDetalle($id);
        require __DIR__ . '/../views/admin/pedidos/detalle.php';
    }

    // Cambiar estado de un pedido
    public function actualizarEstado($id, $estado) {
        return $this->model->actualizarEstado($id, $estado);
    }

    public function cambiarEstado() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['estado'])) {
        $id = intval($_POST['id']);
        $estado = $_POST['estado'];

        require_once __DIR__ . '/../models/PedidoModel.php';
        $pedidoModel = new PedidoModel();

        if ($pedidoModel->actualizarEstado($id, $estado)) {
            header("Location: pedidos.php?mensaje=actualizado");
            exit();
        } else {
            header("Location: pedidos.php?mensaje=error");
            exit();
        }
    } else {
        header("Location: pedidos.php?mensaje=error");
        exit();
    }
}

}
