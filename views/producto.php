<?php
include_once('../includes/db.php');
include_once('../config/config.php');
include_once('partials/header.php');

// Validar ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p class='text-center text-danger mt-5'>Producto no válido.</p>";
  include('partials/footer.php');
  exit;
}

$id = $_GET['id'];

// Obtener producto
$stmt = $pdo->prepare("SELECT productos.*, categorias.nombre AS categoria FROM productos 
                       LEFT JOIN categorias ON productos.categoria_id = categorias.id 
                       WHERE productos.id = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch();

if (!$producto) {
  echo "<p class='text-center text-danger mt-5'>Producto no encontrado.</p>";
  include('partials/footer.php');
  exit;
}

// Obtener imágenes adicionales
$stmtImgs = $pdo->prepare("SELECT imagen FROM producto_imagenes WHERE producto_id = ?");
$stmtImgs->execute([$id]);
$imagenesAdicionales = $stmtImgs->fetchAll(PDO::FETCH_COLUMN);


// Obtener tallas disponibles
$tallasStmt = $pdo->prepare("SELECT tallas.id, tallas.nombre FROM producto_talla 
                             JOIN tallas ON tallas.id = producto_talla.talla_id 
                             WHERE producto_id = ? AND stock > 0");
$tallasStmt->execute([$id]);
$tallas = $tallasStmt->fetchAll();
?>

<style>
.thumb-img {
  transition: transform 0.2s, border 0.2s;
}

.thumb-img:hover {
  transform: scale(1.05);
  border: 2px solid #0d6efd;
}

</style>

<div class="container py-5">
  <div class="row">
    <div class="col-md-6 text-center">

  <!-- Marco principal -->
  <div class="border rounded shadow-sm mb-3 p-2" style="max-height: 450px;">
    <img id="imagenPrincipal"
         src="<?= URL_BASE ?>uploads/<?= $producto['imagen_principal'] ?>"
         alt="<?= htmlspecialchars($producto['nombre']) ?>"
         class="img-fluid"
         style="max-height: 430px; object-fit: contain;">
  </div>

  <!-- Miniaturas -->
  <div class="d-flex flex-wrap justify-content-center gap-2">
    <!-- Imagen principal como primera miniatura -->
    <img src="<?= URL_BASE ?>uploads/<?= $producto['imagen_principal'] ?>"
         class="img-thumbnail thumb-img"
         style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">

    <?php foreach ($imagenesAdicionales as $img): ?>
      <img src="<?= URL_BASE ?>uploads/<?= $img ?>"
           class="img-thumbnail thumb-img"
           style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">
    <?php endforeach; ?>
  </div>

</div>



    <div class="col-md-6">
      <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
      <p class="text-muted">Categoría: <?= htmlspecialchars($producto['categoria']) ?></p>
      <h4 class="text-success"><?= mostrarPrecio($producto['precio']) ?></h4>


      <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>

      <form method="POST" action="../controllers/agregar_carrito.php" id="formAgregarCarrito">
        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">

        <?php if (count($tallas) > 0): ?>
          <h5>Selecciona tallas y cantidades:</h5>

          <?php foreach ($tallas as $talla): ?>
            <div class="row align-items-center mb-2">
              <div class="col-4 col-md-3">
                <strong><?= $talla['nombre'] ?></strong>
              </div>
              <div class="col-8 col-md-4">
                <input type="number" name="tallas[<?= $talla['id'] ?>]" class="form-control" value="0" min="0">
              </div>
            </div>
          <?php endforeach; ?>

          <button type="submit" class="btn btn-primary mt-3" id="btnAgregarCarrito">Agregar al carrito</button>
        <?php else: ?>
          <p class="text-danger">Producto agotado en todas las tallas.</p>
        <?php endif; ?>
      </form>

    </div>
  </div>
</div>


<script>
  document.querySelectorAll('.thumb-img').forEach(img => {
    img.addEventListener('click', () => {
      document.getElementById('imagenPrincipal').src = img.src;
    });
  });
</script>



<script>
  const form = document.getElementById('formAgregarCarrito');
  const boton = document.getElementById('btnAgregarCarrito');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    fetch(form.action, {
      method: 'POST',
      body: new FormData(form)
    })
    .then(() => {
      Swal.fire({
        title: '¡Producto agregado!',
        text: '¿Qué deseas hacer ahora?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Ir al carrito',
        cancelButtonText: 'Seguir comprando'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'carrito.php';
        } else {
          // Reiniciar formulario
          form.reset();
        }
      });
    });
  });
</script>


<?php include('partials/footer.php'); ?>
