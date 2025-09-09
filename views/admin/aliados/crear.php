<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Agregar Nuevo Aliado</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Aliado</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Enlace (web o red social)</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo del Aliado</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Aliado</button>
        <a href="aliados.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
