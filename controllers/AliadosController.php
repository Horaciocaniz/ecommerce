<?php
require_once __DIR__ . '/../models/AliadoModel.php';

class AliadosController {
    private $model;

    public function __construct() {
        $this->model = new AliadoModel();
    }

    // Listar aliados
    public function index() {
        $aliados = $this->model->obtenerTodos();
        require __DIR__ . '/../views/admin/aliados/index.php';
    }

    // Crear nuevo aliado
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $link = $_POST['link'] ?? '';
            $logo = '';

            // Subida de imagen
            if (!empty($_FILES['logo']['name'])) {
                $directorio = __DIR__ . '/../uploads/aliados/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                $nombreArchivo = time() . '_' . basename($_FILES['logo']['name']);
                $rutaDestino = $directorio . $nombreArchivo;

                if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                    $logo = 'uploads/aliados/' . $nombreArchivo;
                }
            }

            $this->model->crear($nombre, $logo, $link);
            header("Location: aliados.php?mensaje=creado");
            exit;
        }

        require __DIR__ . '/../views/admin/aliados/crear.php';
    }

    // Editar aliado
    public function editar($id) {
        $aliado = $this->model->obtenerPorId($id);

        if (!$aliado) {
            header("Location: aliados.php?mensaje=error");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $link = $_POST['link'] ?? '';
            $logo = $aliado['logo'];

            // Subida de imagen (opcional)
            if (!empty($_FILES['logo']['name'])) {
                $directorio = __DIR__ . '/../uploads/aliados/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                $nombreArchivo = time() . '_' . basename($_FILES['logo']['name']);
                $rutaDestino = $directorio . $nombreArchivo;

                if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                    $logo = 'uploads/aliados/' . $nombreArchivo;
                }
            }

            $this->model->actualizar($id, $nombre, $logo, $link);
            header("Location: aliados.php?mensaje=actualizado");
            exit;
        }

        require __DIR__ . '/../views/admin/aliados/editar.php';
    }

    // Eliminar aliado
    public function eliminar($id) {
        $this->model->eliminar($id);
        header("Location: aliados.php?mensaje=eliminado");
        exit;
    }
}
