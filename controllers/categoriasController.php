<?php
require_once __DIR__ . '/../models/CategoriaModel.php';

class CategoriasController {

    private $model;

    public function __construct() {
        $this->model = new CategoriaModel();
    }

    public function index() {
        $categorias = $this->model->obtenerTodas();
        include __DIR__ . '/../views/admin/categorias/index.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            if (!empty($nombre)) {
                $this->model->crear($nombre);
                header('Location: categorias.php?mensaje=creada');
                exit;
            }
        }
        include __DIR__ . '/../views/admin/categorias/crear.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: categorias.php'); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $this->model->actualizar($id, $nombre);
            header('Location: categorias.php?mensaje=editada');
            exit;
        }

        $categoria = $this->model->obtenerPorId($id);
        include __DIR__ . '/../views/admin/categorias/editar.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->eliminar($id);
        }
        header('Location: categorias.php?mensaje=eliminada');
        exit;
    }
}
