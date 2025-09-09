<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4 pedidos-table">
    <h2>Gestión de Pedidos</h2>

    <?php if (!empty($_GET['mensaje'])): ?>
        <div class="alert alert-info">Pedido <?= htmlspecialchars($_GET['mensaje']) ?> correctamente</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center pedidos">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach($pedidos as $pedido): ?>
                        <tr>
                            <td data-label="ID"><?= $pedido['id'] ?></td>
                            <td data-label="Nombre"><?= htmlspecialchars($pedido['nombre']) ?></td>
                            <td data-label="Correo"><?= htmlspecialchars($pedido['correo']) ?></td>
                            <td data-label="Teléfono"><?= htmlspecialchars($pedido['telefono']) ?></td>
                            <td data-label="Total">Q<?= number_format($pedido['total'], 2) ?></td>
                            <td data-label="Estado">
                                <span class="badge 
                                    <?php 
                                        switch($pedido['estado']) {
                                            case 'Pendiente': echo 'bg-danger'; break;
                                            case 'Enviado': echo 'bg-warning text-dark'; break;
                                            case 'Finalizado': echo 'bg-success'; break;
                                            default: echo 'bg-secondary'; break;
                                        }
                                    ?>">
                                    <?= $pedido['estado'] ?>
                                </span>
                            </td>
                            <td data-label="Fecha"><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                            <td data-label="Acciones" class="acciones-td">
                                <div class="acciones-label">Acciones</div> <!-- Solo visible en mobile -->
                                <a href="pedidos_detalle.php?id=<?= $pedido['id'] ?>" 
                                   class="btn btn-outline-info btn-sm w-100 mb-1">
                                    <i class="fas fa-eye"></i> Ver Detalles
                                </a>
                                <button class="btn btn-outline-primary btn-sm w-100 mb-1" 
                                        onclick="cambiarEstado(<?= $pedido['id'] ?>)">
                                    <i class="fas fa-exchange-alt"></i> Cambiar Estado
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay pedidos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function cambiarEstado(id) {
    Swal.fire({
        title: 'Cambiar Estado',
        text: 'Selecciona el nuevo estado para el pedido',
        input: 'select',
        inputOptions: {
            'Pendiente': 'Pendiente',
            'Enviado': 'Enviado',
            'Finalizado': 'Finalizado'
        },
        inputPlaceholder: 'Seleccionar estado',
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'pedidos_estado.php';

            const inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = id;
            form.appendChild(inputId);

            const inputEstado = document.createElement('input');
            inputEstado.type = 'hidden';
            inputEstado.name = 'estado';
            inputEstado.value = result.value; 
            form.appendChild(inputEstado);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
