<?php
require_once __DIR__ . '/../models/PaisModel.php';

class PaisesController {
    private $model;

    public function __construct() {
        $this->model = new PaisModel();
    }

    public function index() {
        $paises = $this->model->obtenerTodos();
        include __DIR__ . '/../views/admin/paises/index.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            if (!empty($nombre)) {
                $this->model->crear($nombre);
                header('Location: paises.php?mensaje=creado');
                exit;
            }
        }
        include __DIR__ . '/../views/admin/paises/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: paises.php'); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $this->model->actualizar($id, $nombre);
            header('Location: paises.php?mensaje=editado');
            exit;
        }

        $pais = $this->model->obtenerPorId($id);
        include __DIR__ . '/../views/admin/paises/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->eliminar($id);
        }
        header('Location: paises.php?mensaje=eliminado');
        exit;
    }
}
