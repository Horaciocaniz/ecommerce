<?php
session_start();
include_once('../config/config.php');
include_once('partials/header.php');

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = [];
}
$carrito = $_SESSION['carrito'];
?>

<div class="container py-5">
  <h1 class="mb-4 text-center">Carrito de Compras</h1>

  <?php if (empty($carrito)): ?>
  <p class="text-center">Tu carrito está vacío. <a href="catalogo.php">Ver productos</a></p>
<?php else: ?>
  <form method="POST" action="../controllers/actualizar_carrito.php">

    <!-- VISTA PARA ESCRITORIO -->
    <div class="table-responsive d-none d-md-block">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Talla</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($carrito as $index => $item):
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
          ?>
          <tr>
            <td>
              <img src="<?= URL_BASE ?>uploads/<?= $item['imagen'] ?>" style="height:60px;width:auto;" class="me-2">
              <?= htmlspecialchars($item['nombre']) ?>
            </td>
            <td><?= htmlspecialchars($item['talla']) ?></td>
            <td><?= mostrarPrecio($item['precio']) ?></td>
            <td style="max-width: 100px;">
              <input type="number" name="cantidades[<?= $index ?>]" value="<?= $item['cantidad'] ?>"
                class="form-control cantidad-input" min="1"
                data-index="<?= $index ?>"
                data-precio="<?= $item['precio'] ?>">
            </td>
            <td class="subtotal" id="subtotal-<?= $index ?>">
              <?= mostrarPrecio($subtotal) ?>
            </td>

            <td>
              <a href="../controllers/eliminar_carrito.php?index=<?= $index ?>" class="btn btn-sm btn-danger">Eliminar</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- VISTA PARA MOBILE -->
    <div class="d-md-none">
      <?php
      $total = 0;
      foreach ($carrito as $index => $item):
        $subtotal = $item['precio'] * $item['cantidad'];
        $total += $subtotal;
      ?>
      <div class="card mb-3 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <img src="<?= URL_BASE ?>uploads/<?= $item['imagen'] ?>" style="height:60px;width:auto;" class="me-3">
            <div>
              <h6 class="mb-1"><?= htmlspecialchars($item['nombre']) ?></h6>
              <small class="text-muted">Talla: <?= htmlspecialchars($item['talla']) ?></small>
            </div>
          </div>
          <p class="mb-1"><strong>Precio:</strong> <?= mostrarPrecio($item['precio']) ?></p>
          <div class="mb-2">
            <strong class="me-2">Cantidad:</strong>
            <div class="input-group" style="width: 130px;">
              <button class="btn btn-outline-secondary btn-sm btn-decrement" type="button" data-index="<?= $index ?>">-</button>
              <input type="text" name="cantidades[<?= $index ?>]" value="<?= $item['cantidad'] ?>" class="form-control text-center cantidad-input" data-index="<?= $index ?>" data-precio="<?= $item['precio'] ?>">
              <button class="btn btn-outline-secondary btn-sm btn-increment" type="button" data-index="<?= $index ?>">+</button>
            </div>
          </div>

          <p class="mb-2"><strong>Subtotal:</strong> <span class="subtotal" id="subtotal-<?= $index ?>"><?= mostrarPrecio($subtotal) ?></span></p>
          <a href="../controllers/eliminar_carrito.php?index=<?= $index ?>" class="btn btn-sm btn-outline-danger w-100">Eliminar</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-4">
      <h4>Total: <span id="total-carrito"><?= mostrarPrecio($total) ?></span></h4>
      <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start align-items-md-center mt-3">
        <span class="text-muted mb-2 mb-md-0">
          <i class="fas fa-sync-alt"></i> Cambios guardados automáticamente
        </span>
        <a href="checkout.php" class="btn btn-primary">Ir al Checkout</a>
      </div>
    </div>
  </form>
<?php endif; ?>

</div>


<script>
const simboloMoneda = "<?= $monedas[$_SESSION['moneda']]['simbolo'] ?>";
const factorMoneda = <?= $monedas[$_SESSION['moneda']]['factor'] ?>;
</script>


<script>
function actualizarCantidad(index, nuevaCantidad) {
  const inputs = document.querySelectorAll(`input[name='cantidades[${index}]']`);
  const precioBase = parseFloat(inputs[0].dataset.precio); // precio en GTQ

  // Actualizar cantidad en todos los inputs
  inputs.forEach(input => {
    input.value = nuevaCantidad;
  });

  // Calcular subtotal en GTQ
  const subtotalGTQ = precioBase * nuevaCantidad;
  // Convertir subtotal a moneda seleccionada
  const subtotalConvertido = (subtotalGTQ * factorMoneda).toFixed(2);

  // Mostrar subtotal con símbolo
  document.querySelectorAll(`#subtotal-${index}`).forEach(el => {
    el.innerText = simboloMoneda + ' ' + subtotalConvertido;
  });

  // Actualizar en backend
  fetch('../controllers/ajax_actualizar_carrito.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `index=${index}&cantidad=${nuevaCantidad}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // data.total viene en GTQ → convertir
      const totalConvertido = (data.total * factorMoneda).toFixed(2);
      document.getElementById('total-carrito').innerText = simboloMoneda + ' ' + totalConvertido;
    } else {
      alert(data.message);
    }
  });
}



// Evento para cambio manual en input
document.querySelectorAll('.cantidad-input').forEach(input => {
  input.addEventListener('change', () => {
    const index = input.dataset.index;
    const cantidad = parseInt(input.value);
    if (cantidad >= 1) {
      actualizarCantidad(index, cantidad);
    }
  });
});

// Botón "+"
document.querySelectorAll('.btn-increment').forEach(btn => {
  btn.addEventListener('click', () => {
    const index = btn.dataset.index;
    const input = document.querySelector(`input[name='cantidades[${index}]']`);
    const cantidadActual = parseInt(input.value);
    actualizarCantidad(index, cantidadActual + 1);
  });
});

// Botón "-"
document.querySelectorAll('.btn-decrement').forEach(btn => {
  btn.addEventListener('click', () => {
    const index = btn.dataset.index;
    const input = document.querySelector(`input[name='cantidades[${index}]']`);
    const cantidadActual = parseInt(input.value);
    if (cantidadActual > 1) {
      actualizarCantidad(index, cantidadActual - 1);
    }
  });
});
</script>




<?php include('partials/footer.php'); ?>
