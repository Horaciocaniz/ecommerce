<?php
require_once __DIR__ . '/../includes/db.php';

// Leer JSON enviado por Recurrente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data || $data['status'] !== 'success') {
    http_response_code(400);
    exit("Pago no confirmado");
}

$metadata = $data['metadata'];
$carrito  = $metadata['carrito'];

try {
    $pdo->beginTransaction();

    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Insertar pedido real
    $stmt = $pdo->prepare("INSERT INTO pedidos 
        (nombre, correo, telefono, direccion, comentario, fecha, total, estado) 
        VALUES (?, ?, ?, ?, ?, NOW(), ?, 'pagado')");
    $stmt->execute([
        $metadata['nombre'], $metadata['correo'], $metadata['telefono'],
        $metadata['direccion'], $metadata['comentario'], $total
    ]);
    $pedido_id = $pdo->lastInsertId();

    // Insertar detalles
    $stmtDetalle = $pdo->prepare("INSERT INTO detalle_pedido 
        (pedido_id, producto_id, talla_id, cantidad, precio_unitario) 
        VALUES (?, ?, ?, ?, ?)");
    $stmtStock = $pdo->prepare("UPDATE producto_talla SET stock = stock - ? WHERE producto_id = ? AND talla_id = ?");

    foreach ($carrito as $item) {
        $stmtDetalle->execute([$pedido_id, $item['producto_id'], $item['talla_id'] ?? null, $item['cantidad'], $item['precio']]);
        if (!empty($item['talla_id'])) {
            $stmtStock->execute([$item['cantidad'], $item['producto_id'], $item['talla_id']]);
        }
    }

    $pdo->commit();
    http_response_code(200);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo "Error: " . $e->getMessage();
}
