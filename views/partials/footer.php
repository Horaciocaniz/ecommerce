<footer class="bg-dark text-white py-5 mt-5">
  <div class="container">
    <div class="row gy-4">
      <!-- Logo y descripción -->
      <div class="col-md-4">
        <div class="d-flex align-items-center mb-3">
  <a class="d-flex align-items-center fw-bold fs-5 text-light text-decoration-none" href="landing.php">
    <img src="<?= URL_BASE ?>assets/img/logoIcon.png" alt="<?= NOMBRE_SITIO ?>" width="100" class="me-2">
    <?= NOMBRE_SITIO ?>
  </a>
</div>


        <p class="text-secondary">
          Tu tienda online de confianza para productos premium.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="https://www.facebook.com/profile.php?id=100089621139478" class="text-secondary fs-5" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://wa.me/16619552368" class="text-secondary fs-5"><i class="fab fa-whatsapp" target="_blank"></i></a>
        </div>
      </div>

      <!-- Enlaces rápidos -->
      <div class="col-md-2">
        <h5 class="mb-3">Enlaces rápidos</h5>
        <ul class="list-unstyled">
          <li><a href="landing.php" class="text-secondary text-decoration-none">Inicio</a></li>
          <li><a href="catalogo.php" class="text-secondary text-decoration-none">Catálogo</a></li>
          <li><a href="faq.php" class="text-secondary text-decoration-none">Preguntas Frecuentes</a></li>
          <li><a href="carrito.php" class="text-secondary text-decoration-none">Carrito</a></li>
        </ul>
      </div>

      

      <!-- Contacto -->
      <div class="col-md-4">
        <h5 class="mb-3">Contáctanos</h5>
        <ul class="list-unstyled text-secondary">
          <li><a href="contacto.php" class="text-secondary text-decoration-none">Contáctanos</a></li>
        </ul>
      </div>
    </div>

    <hr class="border-secondary my-4">

    <div class="text-center text-secondary">
      &copy; <?= date('Y') ?> <?= NOMBRE_SITIO ?>. Todos los derechos reservados. Desarollado por <a href="https://venweb.site" class="text-white text-decoration-none" target="_blank">VenWeb</a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
