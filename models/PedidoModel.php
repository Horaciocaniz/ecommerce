<?php
require_once __DIR__ . '/../includes/db.php';

class PedidoModel {

    private $db;

    public function __construct() {
        // Usamos la variable global $pdo creada en db.php
        global $pdo;
        $this->db = $pdo;
    }

    public function obtenerTodos() {
        $stmt = $this->db->query("SELECT * FROM pedidos ORDER BY fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerDetalle($id) {
    $sql = "SELECT dp.*, 
                   p.nombre AS producto,
                   p.imagen_principal AS imagen,
                   t.nombre AS talla
            FROM detalle_pedido dp
            INNER JOIN productos p ON p.id = dp.producto_id
            LEFT JOIN tallas t ON t.id = dp.talla_id
            WHERE dp.pedido_id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function actualizarEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}

