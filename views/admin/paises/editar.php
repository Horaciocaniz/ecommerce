<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Editar País</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre del País</label>
            <input type="text" name="nombre" class="form-control" value="<?= $pais['nombre'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Actualizar
        </button>
        <a href="paises.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
