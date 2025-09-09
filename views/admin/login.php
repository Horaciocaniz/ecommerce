<?php
session_start();
if (isset($_SESSION['admin'])) {
  header('Location: dashboard.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../assets/img/logoNegro.png">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4 w-100" style="max-width: 400px;">
    <h3 class="text-center mb-4">Panel Administrativo</h3>
    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">Credenciales incorrectas</div>
    <?php endif; ?>
    <form action="../../controllers/login_admin.php" method="POST">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" name="usuario" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
  </div>
</div>

</body>
</html>
