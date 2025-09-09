<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../config/config.php';
include_once('partials/header.php'); 

if (!isset($_GET['pedido_id']) || !is_numeric($_GET['pedido_id'])) {
  die("ID de pedido no válido.");
}
$pedido_id = (int) $_GET['pedido_id'];

// Pedido
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
$stmt->execute([$pedido_id]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$pedido) { die("Pedido no encontrado."); }

// Detalle
$stmt = $pdo->prepare("
  SELECT dp.*, p.nombre AS producto_nombre, t.nombre AS talla
  FROM detalle_pedido dp
  JOIN productos p ON dp.producto_id = p.id
  LEFT JOIN tallas t ON dp.talla_id = t.id
  WHERE dp.pedido_id = ?
");
$stmt->execute([$pedido_id]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gracias por tu compra</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background:#f6f7f9; }
    .thank-card { border:0; border-radius:1rem; }
    .thank-header { border-bottom:0; }
    .icon-circle {
      width:56px; height:56px; border-radius:50%;
      display:flex; align-items:center; justify-content:center;
      background:#eaf7ee; color:#198754; font-size:26px;
      margin:0 auto 12px;
    }
    /* Más aire en móvil */
    .section-title { font-weight:700; margin-bottom:.75rem; }
    .item-card { border:1px solid #e9ecef; border-radius:.75rem; padding:12px; }
    .item-row { display:flex; justify-content:space-between; gap:8px; }
    .label-muted { color:#6c757d; font-size:.925rem; }
  </style>
</head>
<body>

<div class="container py-4 py-md-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card thank-card shadow-lg">
        <div class="card-body p-3 p-md-4 p-lg-5">

          <div class="text-center mb-3 mb-md-4">
            <div class="icon-circle">
              ✓
            </div>
            <h1 class="h3 h2-md text-success mb-1">¡Gracias por tu compra!</h1>
            <p class="text-muted mb-0">Tu pedido ha sido procesado exitosamente.</p>
          </div>

          <!-- Resumen -->
          <h2 class="h5 section-title">Resumen de tu pedido</h2>
          <ul class="list-group mb-4">
            <li class="list-group-item d-flex justify-content-between">
              <strong>Número de pedido:</strong>
              <span>#<?= $pedido['id']; ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Nombre:</strong>
              <span><?= htmlspecialchars($pedido['nombre']); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Correo:</strong>
              <span class="text-break"><?= htmlspecialchars($pedido['correo']); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Teléfono:</strong>
              <span><?= htmlspecialchars($pedido['telefono']); ?></span>
            </li>
            <li class="list-group-item">
              <strong>Dirección:</strong>
              <div class="mt-1 label-muted"><?= nl2br(htmlspecialchars($pedido['direccion'])); ?></div>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Total:</strong>
              <span>Q <?= number_format($pedido['total'], 2); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Estado:</strong>
              <span class="badge bg-success-subtle text-success fw-semibold text-uppercase">
                <?= htmlspecialchars(ucfirst($pedido['estado'])); ?>
              </span>
            </li>
          </ul>

          <!-- Productos (tabla en desktop, cards en mobile) -->
          <h2 class="h5 section-title">Productos</h2>

          <!-- Tabla md+ -->
          <div class="table-responsive d-none d-md-block">
            <table class="table table-striped align-middle">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Talla</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-end">Precio</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($detalles as $item): ?>
                  <tr>
                    <td><?= htmlspecialchars($item['producto_nombre']); ?></td>
                    <td><?= $item['talla'] ?: '-'; ?></td>
                    <td class="text-center"><?= (int)$item['cantidad']; ?></td>
                    <td class="text-end">Q <?= number_format($item['precio_unitario'], 2); ?></td>
                    <td class="text-end">
                      Q <?= number_format($item['cantidad'] * $item['precio_unitario'], 2); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Cards xs-sm -->
          <div class="d-md-none">
            <?php foreach ($detalles as $item): ?>
              <div class="item-card mb-2">
                <div class="fw-semibold mb-1"><?= htmlspecialchars($item['producto_nombre']); ?></div>
                <div class="label-muted mb-2">Talla: <?= $item['talla'] ?: '-'; ?></div>

                <div class="item-row">
                  <span class="label-muted">Cantidad</span>
                  <span><?= (int)$item['cantidad']; ?></span>
                </div>
                <div class="item-row">
                  <span class="label-muted">Precio</span>
                  <span>Q <?= number_format($item['precio_unitario'], 2); ?></span>
                </div>
                <div class="item-row">
                  <span class="fw-semibold">Subtotal</span>
                  <span class="fw-semibold">
                    Q <?= number_format($item['cantidad'] * $item['precio_unitario'], 2); ?>
                  </span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="text-center mt-4">
            <a href="<?= URL_BASE; ?>views/landing.php" class="btn btn-primary btn-lg px-4">Volver a la tienda</a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
