<?php
require_once __DIR__ . '/../../config/config.php';
http_response_code(500);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Error interno (500)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{min-height:100vh;background:#fff5f5;display:flex;align-items:center}
    .card{border:0;border-radius:1rem}
    .emoji{font-size:56px}
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-7">
        <div class="card shadow-lg p-4 p-md-5 text-center">
          <div class="emoji mb-2">🛠️</div>
          <h1 class="h3 mb-2 text-danger">Tuvimos un problema</h1>
          <p class="text-muted mb-4">
            Ocurrió un error inesperado. Nuestro equipo ya fue notificado.
          </p>

          <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <a class="btn btn-primary px-4" href="<?= SITE_URL ?>index.php">Ir al inicio</a>
            <a class="btn btn-outline-secondary px-4" href="javascript:history.back()">Volver</a>
          </div>

          <hr class="my-4">
          <small class="text-muted">Código de error: 500</small>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
