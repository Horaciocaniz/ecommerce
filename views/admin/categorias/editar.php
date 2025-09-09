<?php include_once __DIR__ . '/../partials/header.php'; ?>

<div class="container mt-4">
    <h2>Editar Categoría</h2>

    <?php if (!$categoria): ?>
        <div class="alert alert-danger">La categoría no existe o fue eliminada.</div>
        <a href="categorias.php" class="btn btn-secondary mt-3">Volver</a>
        <?php include_once __DIR__ . '/../partials/footer.php'; exit; ?>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($categoria['nombre']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="categorias.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
