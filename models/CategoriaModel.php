<?php
class CategoriaModel {

    private $pdo;

    public function __construct() {
        // Reutilizamos la conexión global
        require __DIR__ . '/../includes/db.php';
        $this->pdo = $pdo;
    }

    public function obtenerTodas() {
        $stmt = $this->pdo->query("SELECT * FROM categorias ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function crear($nombre) {
        $stmt = $this->pdo->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        return $stmt->execute(['nombre' => $nombre]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function actualizar($id, $nombre) {
        $stmt = $this->pdo->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
        return $stmt->execute(['nombre' => $nombre, 'id' => $id]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
