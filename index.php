<?php
// index.php en /ecommerce/
require_once __DIR__ . '/config/config.php'; // para usar SITE_URL (opcional)
header('Location: ' . SITE_URL . 'views/landing.php', true, 302);
exit;
