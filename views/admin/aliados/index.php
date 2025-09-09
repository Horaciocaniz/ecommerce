<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Gestión de Aliados</h2>

    <?php if (!empty($_GET['mensaje'])): ?>
        <div class="alert alert-info">Aliado <?= htmlspecialchars($_GET['mensaje']) ?> correctamente</div>
    <?php endif; ?>

    <a href="aliados_crear.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Nuevo Aliado</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Nombre</th>
                    <th>Enlace</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($aliados)): ?>
                    <?php foreach($aliados as $aliado): ?>
                        <tr>
                            <td><?= $aliado['id'] ?></td>
                            <td><img src="<?= UPLOADS_URL ?>aliados/<?= htmlspecialchars($aliado['logo']) ?>" alt="<?= htmlspecialchars($aliado['nombre']) ?>" width="120"></td>
                            <td><?= htmlspecialchars($aliado['nombre']) ?></td>
                            <td><a href="<?= htmlspecialchars($aliado['link']) ?>" target="_blank">Visitar</a></td>
                            <td>
                                <a href="aliados_editar.php?id=<?= $aliado['id'] ?>" class="btn btn-primary btn-sm mb-1 w-100"><i class="fas fa-edit"></i> Editar</a>
                                <a href="aliados_eliminar.php?id=<?= $aliado['id'] ?>" class="btn btn-danger btn-sm w-100" onclick="return confirm('¿Seguro de eliminar?')"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No hay aliados registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
