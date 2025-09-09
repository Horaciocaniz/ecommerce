<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Detalle del Pedido #<?= $pedido['id'] ?></h2>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['nombre']) ?></p>
    <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['correo']) ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($pedido['telefono']) ?></p>
    <p><strong>Dirección:</strong> <?= htmlspecialchars($pedido['direccion']) ?></p>
    <p><strong>Comentario:</strong> 
    <?= !empty($pedido['comentario']) ? nl2br(htmlspecialchars($pedido['comentario'])) : '<em>Sin comentario</em>' ?>
    </p>
    <p><strong>Total:</strong> Q<?= number_format($pedido['total'], 2) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($pedido['estado']) ?></p>
    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></p>

    <h4 class="mt-4">Productos</h4>
    <div class="table-responsive">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($detalle as $item): ?>
                    <tr>
                        <td>
                            <img src="<?= URL_BASE ?>/uploads/<?= htmlspecialchars($item['imagen']) ?>" 
                                 alt="<?= htmlspecialchars($item['producto']) ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td><?= htmlspecialchars($item['producto']) ?></td>
                        <td><?= $item['talla'] ?: '-' ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>Q<?= number_format($item['precio_unitario'], 2) ?></td>
                        <td>Q<?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="pedidos.php" class="btn btn-secondary mt-3">Volver</a>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
