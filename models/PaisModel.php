<?php
require_once __DIR__ . '/../includes/db.php';

class PaisModel {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM paises ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM paises WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function crear($nombre) {
        $stmt = $this->pdo->prepare("INSERT INTO paises (nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    public function actualizar($id, $nombre) {
        $stmt = $this->pdo->prepare("UPDATE paises SET nombre = ? WHERE id = ?");
        return $stmt->execute([$nombre, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM paises WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
