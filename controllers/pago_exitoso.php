<?php
session_start();
require_once __DIR__ . '/../config/config.php';  // define SITE_URL (y URL_BASE si quieres alias)
require_once __DIR__ . '/../includes/db.php';

// (Opcional) Recurrente te manda ?checkout_id=... por querystring
$checkoutId = $_GET['checkout_id'] ?? null;
// Aquí podrías validar el estado del checkout consultando la API de Recurrente con $checkoutId.
// Si no lo haces ahora, al menos asegúrate que vienes de su success_url (ya lo estás haciendo).

// Debemos tener los datos del checkout guardados en sesión desde procesar_checkout.php
if (empty($_SESSION['checkout_data']) || empty($_SESSION['checkout_data']['carrito'])) {
    http_response_code(400);
    echo "La sesión de checkout no está disponible. Vuelve a intentarlo.";
    exit;
}

$checkout = $_SESSION['checkout_data'];
$carrito  = $checkout['carrito'];

try {
    $pdo->beginTransaction();

    // Calcular total en GTQ (tu moneda base)
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // 1) Insertar pedido como 'pagado'
    $stmt = $pdo->prepare("INSERT INTO pedidos 
        (nombre, correo, telefono, direccion, comentario, fecha, total, estado)
        VALUES (?, ?, ?, ?, ?, NOW(), ?, 'pendiente')");
    $stmt->execute([
        $checkout['nombre'],
        $checkout['correo'],
        $checkout['telefono'],
        $checkout['direccion'],
        $checkout['comentario'] ?? null,
        $total
    ]);
    $pedido_id = $pdo->lastInsertId();

    // 2) Insertar detalle + actualizar stock
    $stmtDetalle = $pdo->prepare("INSERT INTO detalle_pedido 
        (pedido_id, producto_id, talla_id, cantidad, precio_unitario)
        VALUES (?, ?, ?, ?, ?)");
    $stmtStock = $pdo->prepare("UPDATE producto_talla 
        SET stock = stock - ? WHERE producto_id = ? AND talla_id = ?");

    foreach ($carrito as $item) {
        $prodId  = $item['producto_id'];
        $tallaId = $item['talla_id'] ?? null;
        $cant    = $item['cantidad'];
        $precio  = $item['precio'];

        $stmtDetalle->execute([$pedido_id, $prodId, $tallaId, $cant, $precio]);

        if (!empty($tallaId)) {
            $stmtStock->execute([$cant, $prodId, $tallaId]);
        }
    }

    $pdo->commit();

    // 3) Limpiar carrito/sesión y redirigir a "gracias"
    $_SESSION['carrito'] = [];
    unset($_SESSION['checkout_data']);

    // Usa SITE_URL (absoluta) para evitar problemas con Recurrente
    header("Location: " . SITE_URL . "views/gracias.php?pedido_id=" . $pedido_id);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo "Error al crear el pedido: " . $e->getMessage();
    exit;
}
