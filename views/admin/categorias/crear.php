<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Nueva Categoría</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Crear</button>
        <a href="categorias.php" class="btn btn-secondary">Volver</a>
    </form>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
