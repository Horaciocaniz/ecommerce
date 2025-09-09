<?php
session_start();
include_once('../config/config.php');
include_once('partials/header.php');

// Proteger acceso si carrito está vacío
$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
  echo "<div class='container py-5 text-center'><p>Tu carrito está vacío. <a href='catalogo.php'>Ir al catálogo</a></p></div>";
  include('partials/footer.php');
  exit;
}
?>

<div class="container py-5">
  <h1 class="mb-4 text-center">Checkout</h1>

  <form method="POST" action="../controllers/procesar_checkout.php">
    <div class="row">
      <!-- Datos del cliente -->
      <div class="col-md-6 mb-4">
        <h4>Información del Cliente</h4>

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre completo</label>
          <input type="text" class="form-control" name="nombre" id="nombre" required>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" name="correo" id="correo" required>
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" class="form-control" name="telefono" id="telefono" required>
        </div>

        <div class="mb-3">
          <label for="direccion" class="form-label">Dirección de envío</label>
          <textarea class="form-control" name="direccion" id="direccion" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="comentario" class="form-label">Comentario (opcional)</label>
          <textarea class="form-control" name="comentario" id="comentario" rows="3"
                    placeholder="Ejemplo: Enviar en empaque de regalo, personalizar con iniciales, etc."></textarea>
        </div>

      </div>

      <!-- Resumen del pedido -->
      <div class="col-md-6 mb-4">
        <h4>Resumen de Compra</h4>

        <ul class="list-group mb-3">
          <?php
          $total = 0;
          foreach ($carrito as $item):
            $subtotal = $item['cantidad'] * $item['precio'];
            $total += $subtotal;
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong><?= htmlspecialchars($item['nombre']) ?></strong><br>
                Talla: <?= htmlspecialchars($item['talla']) ?><br>
                Cantidad: <?= $item['cantidad'] ?>
              </div>
              <span><?= mostrarPrecio($subtotal) ?></span>
            </li>
          <?php endforeach; ?>
          <li class="list-group-item d-flex justify-content-between">
            <strong>Total</strong>
            <strong><?= mostrarPrecio($total) ?></strong>
          </li>
        </ul>

        <button type="submit" class="btn btn-success btn-lg w-100">Pagar ahora</button>
        <small class="text-muted">Los precios se muestran en tu moneda local (referencial). El cobro se procesa en Quetzales (GTQ) o USD.</small>

      </div>
    </div>
  </form>
</div>

<?php include('partials/footer.php'); ?>
