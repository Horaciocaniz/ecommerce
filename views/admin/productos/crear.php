<?php
include_once '../partials/header.php';
require_once '../../../includes/db.php';

// Obtener categorías y países
$categorias = $pdo->query("SELECT id, nombre FROM categorias")->fetchAll();
$paises = $pdo->query("SELECT id, nombre FROM paises")->fetchAll();
?>

<div class="container py-4">
  <h2>Agregar Nuevo Producto</h2>
  <form action="../../../controllers/producto_crear.php" method="POST" enctype="multipart/form-data">
    
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del Producto</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio (en GTQ)</label>
      <input type="number" name="precio" id="precio" class="form-control" step="0.01" required>
    </div>

    <div class="mb-3">
      <label for="categoria" class="form-label">Categoría</label>
      <select name="categoria" id="categoria" class="form-select" required>
        <option value="">Seleccione una categoría</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="pais" class="form-label">País</label>
      <select name="pais" id="pais" class="form-select" required>
        <option value="">Seleccione un país</option>
        <?php foreach ($paises as $p): ?>
          <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
    <label class="form-label">Tallas disponibles y stock</label>
    <div class="row">
        <?php
        $tallas = $pdo->query("SELECT * FROM tallas")->fetchAll();
        foreach ($tallas as $t) : ?>
        <div class="col-md-3 mb-2">
            <label><?= htmlspecialchars($t['nombre']) ?></label>
            <input type="hidden" name="tallas[]" value="<?= $t['id'] ?>">
            <input type="number" name="stock_<?= $t['id'] ?>" class="form-control" placeholder="Stock" min="0" value="0">
        </div>
        <?php endforeach; ?>
    </div>
    </div>


    <div class="mb-3">
  <label for="imagen" class="form-label">Imagen principal del producto</label>
  <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
</div>

<div class="mb-3">
  <label for="imagenes" class="form-label">Imágenes adicionales (máx. 5)</label>
  <input type="file" name="imagenes[]" id="imagenes" class="form-control" multiple accept="image/*">
  <small class="text-muted">Puedes seleccionar hasta 5 imágenes adicionales.</small>
</div>


    <button type="submit" class="btn btn-primary">Guardar Producto</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include_once '../partials/footer.php'; ?>
