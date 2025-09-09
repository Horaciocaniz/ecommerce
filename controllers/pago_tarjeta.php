<?php
session_start();
require_once __DIR__ . '/../config/config.php';

// Asegurar que tenemos datos del checkout
if (empty($_SESSION['checkout_data']) || empty($_SESSION['checkout_data']['carrito'])) {
  die("No hay datos de compra en sesión.");
}

$checkout = $_SESSION['checkout_data'];
$carrito  = $checkout['carrito'];

// 1) Construir ítems para Recurrente desde la sesión (no desde BD)
$items = [];
foreach ($carrito as $row) {
  $nombre = $row['nombre'];
  if (!empty($row['talla'])) {
    $nombre .= ' - ' . $row['talla'];
  }

  $imagen = !empty($row['imagen'])
    ? URL_BASE . "uploads/" . $row['imagen']
    : URL_BASE . "assets/img/default-product.png";

  $items[] = [
    "name"            => $nombre,
    "currency"        => "GTQ",
    "amount_in_cents" => (int) round(((float)$row['precio']) * 100), // precio base GTQ
    "quantity"        => (int) $row['cantidad'],
    "image_url"       => $imagen
  ];
}


$successUrl = SITE_URL . 'controllers/pago_exitoso.php';
$cancelUrl  = SITE_URL . 'views/checkout.php?error=cancelado';

// Validación opcional:
if (!filter_var($successUrl, FILTER_VALIDATE_URL)) die("success_url inválida");
if (!filter_var($cancelUrl,  FILTER_VALIDATE_URL)) die("cancel_url inválida");

// ... payload para Recurrente:
$payload = [
  "items"       => $items,
  "success_url" => $successUrl,
  "cancel_url"  => $cancelUrl,
  "metadata"    => [
    "nombre"     => $checkout['nombre'],
    "correo"     => $checkout['correo'],
    "telefono"   => $checkout['telefono'],
    "direccion"  => $checkout['direccion'],
    "comentario" => $checkout['comentario'],
  ]
];



// 3) Llamar a Recurrente
$ch = curl_init(RECURRENTE_URL);
curl_setopt_array($ch, [
  CURLOPT_POST           => true,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER     => [
    "Content-Type: application/json",
    "X-PUBLIC-KEY: " . RECURRENTE_PUBLIC_KEY,
    "X-SECRET-KEY: " . RECURRENTE_SECRET_KEY
  ],
  CURLOPT_POSTFIELDS     => json_encode($payload)
]);

$response     = curl_exec($ch);
$http_status  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_err     = curl_errno($ch) ? curl_error($ch) : null;
curl_close($ch);

if ($curl_err) {
  die("cURL Error: " . $curl_err);
}

if ($http_status !== 200 && $http_status !== 201) {
  echo "<h2>Error al generar el enlace de pago</h2>";
  echo "<pre>HTTP STATUS: $http_status\n\n";
  echo htmlspecialchars($response);
  echo "</pre>";
  exit;
}

$resultado = json_decode($response, true);
$link_pago = $resultado['checkout_url'] ?? null;

if (!$link_pago) {
  echo "<h2>El API respondió, pero no devolvió 'checkout_url'</h2>";
  echo "<pre>";
  print_r($resultado);
  echo "</pre>";
  exit;
}

// 4) Redirigir al checkout de Recurrente
header("Location: $link_pago");
exit;
