<?php include('../../includes/auth_admin.php'); ?>
<?php include('partials/header.php'); ?>

<div class="container py-4">
  <h1 class="mb-4">Bienvenido al panel, <?= $_SESSION['admin'] ?></h1>
  <p>Desde aquí puedes gestionar productos, pedidos, categorías y más.</p>

  <div class="row g-3">
    <div class="col-6 col-md-4">
      <a href="productos/index.php" class="btn btn-outline-primary w-100"><i class="fas fa-boxes"></i> Productos</a>
    </div>
    <div class="col-6 col-md-4">
      <a href="pedidos.php" class="btn btn-outline-success w-100"><i class="fas fa-receipt"></i> Pedidos</a>
    </div>
    <div class="col-6 col-md-4">
      <a href="categorias.php" class="btn btn-outline-secondary w-100"><i class="fas fa-tags"></i> Categorías</a>
    </div>
    <div class="col-6 col-md-4">
      <a href="paises.php" class="btn btn-outline-info w-100"><i class="fa-solid fa-earth-americas"></i> Paises</a>
    </div>
    <div class="col-6 col-md-4">
      <a href="aliados.php" class="btn btn-outline-secondary w-100"><i class="fa-regular fa-handshake"></i> Aliados</a>
    </div>
    
    
  </div>
</div>

<?php include('partials/footer.php'); ?>
