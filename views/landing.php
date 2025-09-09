<?php 

// en cualquier vista (p.ej. views/landing.php)
include_once __DIR__ . '/../includes/db.php';
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/partials/header.php';

include_once(__DIR__ . '/../models/producto_model.php');

// Traer productos (puedes limitar a 4 destacados)
$productos = $pdo->query("
    SELECT p.*, c.nombre AS categoria, pa.nombre AS pais
    FROM productos p
    LEFT JOIN categorias c ON p.categoria_id = c.id
    LEFT JOIN paises pa ON p.pais_id = pa.id
    ORDER BY p.fecha_creacion DESC
    LIMIT 4
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- CSS opcional -->
<style>
.hero {
  min-height: 80vh; /* Altura mínima */
  display: flex;
  align-items: center;
}

.hero-img {
  max-height: 500px; /* Ajusta el tamaño máximo */
}
</style>




<div class="container-fluid px-0">
  


 <!-- Hero Section -->
<section class="hero py-5">
  <div class="container">
    <div class="row align-items-center flex-column-reverse flex-lg-row">
      
      <!-- Texto -->
      <div class="col-lg-6 text-center text-lg-start mt-4 mt-lg-0">
        <h1 class="display-4 fw-bold mb-3">
          Guantes de Porteros profesionales
        </h1>
        <p class="lead mb-4">
          Convierte tus reflejos en atajadas y marca la diferencia.
        </p>
        <a href="catalogo.php" class="btn btn-primary btn-lg px-4">
          Ver Catálogo
        </a>
      </div>

      <!-- Imagen -->
      <div class="col-lg-6 text-center">
        <img src="<?= URL_BASE ?>assets/img/guante.png"" alt="Hero Portero" class="img-fluid hero-img">
      </div>
      
    </div>
  </div>
</section>

  <!-- Productos Destacados -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Productos Destacados</h2>
      <p class="text-muted">Descubre nuestra selección premium de productos más populares</p>
    </div>

    <div class="row g-4">
      <?php foreach ($productos as $prod): ?>
        <div class="col-md-3 col-sm-6">
          <div class="card h-100 shadow-sm">
            <img src="<?= URL_BASE ?>uploads/<?= htmlspecialchars($prod['imagen_principal']) ?>" class="card-img-top" style="object-fit:cover;height:200px;">
            <div class="card-body text-center d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($prod['nombre']) ?></h5>
              <p class="text-primary fw-bold mb-3"><?= mostrarPrecio($prod['precio']) ?></p>
              <a href="<?= URL_BASE ?>views/producto.php?id=<?= $prod['id'] ?>" class="btn btn-outline-primary mt-auto">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


 
<!-- Beneficios -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-dark mb-3">¿Por qué elegirnos?</h2>
      <p class="text-muted fs-5">Ofrecemos la mejor experiencia de compra online</p>
    </div>

    <div class="row g-4">
      <div class="col-md-4 text-center">
        <div class="mb-4">
          <div class="p-4 bg-primary bg-opacity-10 rounded-circle d-inline-flex">
            <i class="fas fa-shipping-fast fa-2x text-primary"></i>
          </div>
        </div>
        <h5 class="fw-semibold text-dark">Envíos Rápidos</h5>
        <p class="text-muted">Recibe tu pedido en 48-72 horas en toda la ciudad.</p>
      </div>

      <div class="col-md-4 text-center">
        <div class="mb-4">
          <div class="p-4 bg-primary bg-opacity-10 rounded-circle d-inline-flex">
            <i class="fas fa-lock fa-2x text-primary"></i>
          </div>
        </div>
        <h5 class="fw-semibold text-dark">Pago Seguro</h5>
        <p class="text-muted">Transacciones 100% seguras con encriptación SSL. Aceptamos todas las tarjetas y métodos de pago.</p>
      </div>

      <div class="col-md-4 text-center">
        <div class="mb-4">
          <div class="p-4 bg-primary bg-opacity-10 rounded-circle d-inline-flex">
            <i class="fas fa-star fa-2x text-primary"></i>
          </div>
        </div>
        <h5 class="fw-semibold text-dark">Calidad Garantizada</h5>
        <p class="text-muted">Productos originales con garantía oficial. 30 días para devoluciones sin preguntas.</p>
      </div>
    </div>
  </div>
</section>

  

  <!-- ALIADOS / PATROCINADORES -->
  <div class="aliados-section bg-white py-5">
    <h2 class="text-center mb-4">Marcas que confian en nosotros</h2>
    <div class="aliados-carousel d-flex align-items-center">
      <div class="aliados-track d-flex flex-nowrap">
        <?php
        $stmt = $pdo->query("SELECT * FROM aliados");
        $aliados = $stmt->fetchAll();

        // Imprimimos 2 veces para efecto infinito
        for ($i = 0; $i < 2; $i++):
          foreach ($aliados as $aliado):
        ?>
            <div class="aliado px-4 flex-shrink-0">
              <a href="<?= htmlspecialchars($aliado['link']) ?>" target="_blank">
                <img src="../uploads/aliados/<?= htmlspecialchars($aliado['logo']) ?>" 
                     alt="<?= htmlspecialchars($aliado['nombre']) ?>" 
                     class="img-fluid">
              </a>
            </div>
        <?php 
          endforeach;
        endfor;
        ?>
      </div>
    </div>
  </div>
</div>




<style>
.aliados-carousel {
  width: 100%;
  overflow: hidden; /* Ocultamos el scroll, solo animación */
  position: relative;
}

.aliados-track {
  display: flex;
  flex-wrap: nowrap;
  width: max-content; /* Ajusta al contenido para que la animación sea natural */
  animation: scroll 30s linear infinite;
}

.aliado {
  flex: 0 0 auto;
  padding: 0 40px;
}

.aliado img {
  max-height: 80px;
  transition: transform 0.3s;
  display: block;
}

.aliado img:hover {
  transform: scale(1.1);
}

@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); } /* Mitad del contenido porque duplicamos logos */
}

/* Pausar animación cuando el usuario pasa el mouse */
.aliados-carousel:hover .aliados-track {
  animation-play-state: paused;
  cursor: grab;
}

</style>



<?php include('partials/footer.php'); ?>
