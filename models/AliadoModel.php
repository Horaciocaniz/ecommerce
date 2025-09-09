<?php
require_once __DIR__ . '/../includes/db.php';

class AliadoModel {
    private $db;

    public function __construct() {
        global $pdo;
        $this->db = $pdo;
    }

    // Obtener todos los aliados
    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM aliados ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un aliado por ID
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM aliados WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear un aliado (solo guarda el nombre del archivo del logo)
    public function crear($nombre, $logo, $link) {
        $nombreArchivo = basename($logo); // extrae solo el nombre del archivo
        $stmt = $this->db->prepare("INSERT INTO aliados (nombre, logo, link) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $nombreArchivo, $link]);
    }

    // Actualizar un aliado (igual, guarda solo el nombre del archivo)
    public function actualizar($id, $nombre, $logo, $link) {
        $nombreArchivo = basename($logo);
        $stmt = $this->db->prepare("UPDATE aliados SET nombre = ?, logo = ?, link = ? WHERE id = ?");
        return $stmt->execute([$nombre, $nombreArchivo, $link, $id]);
    }

    // Eliminar un aliado
    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM aliados WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
