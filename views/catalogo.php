<?php 
include_once('../includes/db.php'); 
include_once('../config/config.php'); 
include_once('partials/header.php'); 
?>

<?php 
// Traer categorías y países ANTES de renderizar el modal
$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll();
$paises = $pdo->query("SELECT * FROM paises")->fetchAll();
?>

<div class="container py-5">
  <h1 class="text-center mb-4">Catálogo de Productos</h1>

  <div class="text-center mb-4">
  <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalFiltros">
    <i class="fa-solid fa-arrow-down-wide-short"></i> Agregar Filtros
  </button>
</div>


  <!-- Modal Filtros -->
<div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFiltrosLabel">Filtros de búsqueda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="GET" class="row g-3">
          <div class="col-12">
            <label class="form-label">Categoría</label>
            <select name="categoria" class="form-select">
              <option value="">Todas las Categorías</option>
              <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= ($_GET['categoria'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($cat['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-6">
            <label class="form-label">Precio mín</label>
            <input type="number" step="0.01" name="precio_min" class="form-control"
                   value="<?= $_GET['precio_min'] ?? '' ?>">
          </div>
          <div class="col-6">
            <label class="form-label">Precio máx</label>
            <input type="number" step="0.01" name="precio_max" class="form-control"
                   value="<?= $_GET['precio_max'] ?? '' ?>">
          </div>

          <div class="col-12">
            <label class="form-label">País</label>
            <select name="pais" class="form-select">
              <option value="">Todos los Países</option>
              <?php foreach ($paises as $pais): ?>
                <option value="<?= $pais['id'] ?>" <?= ($_GET['pais'] ?? '') == $pais['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($pais['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-12 d-grid">
            <button class="btn btn-primary" type="submit">Aplicar filtros</button>
          </div>
          <div class="col-12 d-grid">
            <a href="catalogo.php" class="btn btn-secondary">Limpiar filtros</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- RESULTADOS -->
  <div class="row">
    <?php
    // Construimos la consulta con filtros
    $sql = "SELECT * FROM productos WHERE 1=1";
    $params = [];

    if (!empty($_GET['categoria'])) {
      $sql .= " AND categoria_id = ?";
      $params[] = $_GET['categoria'];
    }

    $monedaSeleccionada = $_SESSION['moneda'] ?? 'GTQ';
    $factor = $monedas[$monedaSeleccionada]['factor'] ?? 1;

    // Convertir valores ingresados (moneda local → GTQ)
    if (!empty($_GET['precio_min'])) {
      $precioMinGTQ = $_GET['precio_min'] / $factor;
      $sql .= " AND precio >= ?";
      $params[] = $precioMinGTQ;
    }

    if (!empty($_GET['precio_max'])) {
      $precioMaxGTQ = $_GET['precio_max'] / $factor;
      $sql .= " AND precio <= ?";
      $params[] = $precioMaxGTQ;
    }


    if (!empty($_GET['pais'])) {
      $sql .= " AND pais_id = ?";
      $params[] = $_GET['pais'];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $productos = $stmt->fetchAll();

    if (!$productos) {
      echo "<p class='text-center'>No se encontraron productos con los filtros seleccionados.</p>";
    }

    foreach ($productos as $prod):
    ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <img src="<?= URL_BASE ?>uploads/<?= $prod['imagen_principal'] ?>" class="card-img-top" style="object-fit:cover;height:200px;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h5>
            <p class="card-text fw-bold"><?= mostrarPrecio($prod['precio']) ?></p>
            <a href="producto.php?id=<?= $prod['id'] ?>" class="btn btn-outline-primary mt-auto">Ver detalle</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include('partials/footer.php'); ?>
