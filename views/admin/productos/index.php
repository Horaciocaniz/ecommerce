<?php
include_once(__DIR__ . '/../../../config/config.php');
include_once(ROOT_PATH . '/includes/auth_admin.php');
// conexión a la BD
include_once(__DIR__ . '/../../../includes/db.php');

// header del admin
include_once(__DIR__ . '/../partials/header.php');

include_once(ROOT_PATH . '/models/producto_model.php');



$productos = obtenerProductos($pdo);
?>

<div class="container py-4">
  
  <?php if (isset($_GET['eliminado'])): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Producto eliminado',
        showConfirmButton: false,
        timer: 1500
      });
    </script>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Productos</h2>
    <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Nuevo</a>
  </div>

  <div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Imagen</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Categoría</th>
        <th>País</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><img src="../../../uploads/<?= $p['imagen_principal'] ?>" width="60"></td>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td>GTQ <?= number_format($p['precio'], 2) ?></td>
          <td><?= $p['categoria'] ?? 'Sin categoría' ?></td>
          <td><?= $p['pais'] ?? 'Sin país' ?></td>
          <td><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></td>
          <td>
            
            <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary me-1 w-100 mb-1">
              <i class="fas fa-edit"></i> Editar
            </a>
            <button onclick="confirmarEliminacion(<?= $p['id'] ?>)" class="btn btn-sm btn-outline-danger w-100">
              <i class="fas fa-trash-alt"></i> Eliminar
            </button>

          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Incluye SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmarEliminacion(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esto eliminará el producto permanentemente.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '../../../controllers/eliminar_producto.php?id=' + id;
    }
  });
}
</script>



<?php // footer del admin
include_once(__DIR__ . '/../partials/footer.php');
 ?>

