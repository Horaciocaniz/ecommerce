<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Editar Aliado</h2>

    <form action="" method="POST" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Aliado</label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="<?= htmlspecialchars($aliado['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Enlace (web o red social)</label>
            <input type="url" name="link" id="link" class="form-control"
                   value="<?= htmlspecialchars($aliado['link']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Logo Actual</label><br>
            <?php if (!empty($aliado['logo'])): ?>
                <img src="<?= UPLOADS_URL ?>aliados/<?= htmlspecialchars($aliado['logo']) ?>" 
                    alt="<?= htmlspecialchars($aliado['nombre']) ?>" 
                    style="max-width: 150px; border: 1px solid #ccc; padding: 3px;">
            <?php else: ?>
                <p>No hay logo</p>
            <?php endif; ?>
        </div>


        <div class="mb-3">
            <label for="logo" class="form-label">Cambiar Logo (opcional)</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
        <a href="aliados.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
