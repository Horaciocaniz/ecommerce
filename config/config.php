<?php
// =========================
// Configuración General
// =========================

define('NOMBRE_SITIO', 'ProvasSport');
define('MONEDA', 'GTQ');

// En desarrollo con ngrok:
define('SITE_URL', 'https://641c51c1623e.ngrok-free.app/ecommerce/'); // termina con /



define('SITE_URL', 'https://provas.great-site.net/ecommerce/'); // termina con /
define('DB_HOST', 'sql306.infinityfree.com');  // host que te da el panel
define('DB_NAME', 'if0_39897377_ecommerce');
define('DB_USER', 'if0_39897377');
define('DB_PASS', 'Lachocaniz7');




// =========================
// Llaves Recurrente
// =========================

define('RECURRENTE_PUBLIC_KEY', 'pk_live_DaAe09b0LRLSMNjYXOvdIRG3hYvcLSbkHB7yPWCdyFsGI10OaIjvu61CN');
define('RECURRENTE_SECRET_KEY', 'sk_live_YmuNwvzAbRX1WXGbJwt7cdySqMX2O27SSskxdbCQAaX4xIAqdjpTWskfR');

// Endpoint de Recurrente
// 👉 Para pruebas y producción es el mismo endpoint,
// lo que cambia son las llaves que uses (TEST vs LIVE).
define("RECURRENTE_URL", "https://app.recurrente.com/api/checkouts");



// Mostrar menos información en prod
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php-error.log'); // crea la carpeta logs con permisos
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);


register_shutdown_function(function () {
  $e = error_get_last();
  if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
    // Redirige solo si no hay salida previa
    if (!headers_sent()) {
      header("Location: " . SITE_URL . "views/errors/500.php");
      exit;
    }
  }
});



// =========================
// URL BASE DINÁMICA
// =========================

// Detectar el host actual
$host = $_SERVER['HTTP_HOST'];

// Subcarpeta (si tu proyecto está en localhost/ecommerce/)
$subfolder = '/ecommerce/';

// Usar URL relativa al protocolo para evitar problemas de HTTP/HTTPS
$protocol = '//';

// Definir URL base
define('URL_BASE', $protocol . $host . $subfolder);

// URL para el admin
define('ADMIN_URL', URL_BASE . 'views/admin/');

// =========================
// Rutas de archivos
// =========================

define('ROOT_PATH', realpath(__DIR__ . '/../'));
define('UPLOADS_URL', URL_BASE . 'uploads/');
?>
