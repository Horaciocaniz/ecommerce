<?php
require_once '../../../includes/db.php';
include_once '../partials/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de producto no proporcionado.");
}

// Obtener producto
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
    die("Producto no encontrado.");
}

// Obtener tallas y stock
$tallas = $pdo->query("SELECT * FROM tallas")->fetchAll();

$stmtTallas = $pdo->prepare("SELECT talla_id, stock FROM producto_talla WHERE producto_id = ?");
$stmtTallas->execute([$id]);
$stocks = $stmtTallas->fetchAll(PDO::FETCH_KEY_PAIR); // talla_id => stock

// Obtener categorías y países
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
$paises = $pdo->query("SELECT * FROM paises")->fetchAll();

// Obtener imágenes adicionales
$stmtImgs = $pdo->prepare("SELECT * FROM producto_imagenes WHERE producto_id = ?");
$stmtImgs->execute([$id]);
$imagenesAdicionales = $stmtImgs->fetchAll();
?>

<div class="container py-4">
  <h2>Editar Producto</h2>
  <form action="../../../controllers/producto_editar.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">

    <!-- Nombre -->
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" 
             value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    </div>

    <!-- Precio -->
    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" name="precio" id="precio" class="form-control" 
             value="<?= $producto['precio'] ?>" step="0.01" required>
    </div>

    <!-- Categoría -->
    <div class="mb-3">
      <label for="categoria" class="form-label">Categoría</label>
      <select name="categoria" id="categoria" class="form-control" required>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $producto['categoria_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- País -->
    <div class="mb-3">
      <label for="pais" class="form-label">País</label>
      <select name="pais" id="pais" class="form-control" required>
        <?php foreach ($paises as $p): ?>
          <option value="<?= $p['id'] ?>" <?= $p['id'] == $producto['pais_id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Imagen principal -->
    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen Principal</label>
      <?php if ($producto['imagen_principal']): ?>
        <div class="mb-2">
          <img src="../../../uploads/<?= $producto['imagen_principal'] ?>" alt="" height="100">
        </div>
      <?php endif; ?>
      <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
      <input type="hidden" name="imagen_actual" value="<?= $producto['imagen_principal'] ?>">
    </div>

    <!-- Imágenes adicionales existentes -->
    <?php if (!empty($imagenesAdicionales)): ?>
    <div class="mb-3">
      <label class="form-label">Imágenes Adicionales</label>
      <div class="row">
        <?php foreach ($imagenesAdicionales as $img): ?>
          <div class="col-md-2 text-center mb-3">
            <img src="../../../uploads/<?= htmlspecialchars($img['imagen']) ?>" alt="" class="img-fluid mb-1">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" 
                     name="eliminar_imagenes[]" value="<?= $img['id'] ?>" id="img<?= $img['id'] ?>">
              <label class="form-check-label small" for="img<?= $img['id'] ?>">
                Eliminar
              </label>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Subir nuevas imágenes adicionales -->
    <div class="mb-3">
      <label for="imagenes" class="form-label">Agregar Imágenes Adicionales (máx. 5)</label>
      <input type="file" name="imagenes[]" id="imagenes" class="form-control" accept="image/*" multiple>
    </div>

    <!-- Tallas y stock -->
    <div class="mb-3">
      <label class="form-label">Tallas y Stock</label>
      <div class="row">
        <?php foreach ($tallas as $t): ?>
          <div class="col-md-3 mb-2">
            <label><?= htmlspecialchars($t['nombre']) ?></label>
            <input type="hidden" name="tallas[]" value="<?= $t['id'] ?>">
            <input type="number" name="stock_<?= $t['id'] ?>" class="form-control" placeholder="Stock" min="0"
                   value="<?= $stocks[$t['id']] ?? 0 ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<?php include_once '../partials/footer.php'; ?>
