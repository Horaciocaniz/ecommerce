<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Lista de monedas y países
$monedas = [
    'GTQ' => ['nombre' => 'Guatemala',     'simbolo' => 'Q',   'factor' => 1,     'flag' => 'gt'],
    'USD' => ['nombre' => 'Estados Unidos','simbolo' => '$',   'factor' => 0.13,  'flag' => 'us'],
    'MXN' => ['nombre' => 'México',        'simbolo' => 'MX$', 'factor' => 2.43,  'flag' => 'mx'],
    'CRC' => ['nombre' => 'Costa Rica',    'simbolo' => '₡',   'factor' => 70,    'flag' => 'cr'],
    'HNL' => ['nombre' => 'Honduras',      'simbolo' => 'L',   'factor' => 3.40,  'flag' => 'hn'],
    'SVC' => ['nombre' => 'El Salvador',   'simbolo' => '$',   'factor' => 0.13,  'flag' => 'sv'],
    'ARS' => ['nombre' => 'Argentina',     'simbolo' => '$',   'factor' => 186,    'flag' => 'ar'],
    'COP' => ['nombre' => 'Colombia',      'simbolo' => '$',   'factor' => 520,   'flag' => 'co'],
    'EUR' => ['nombre' => 'Europa',        'simbolo' => '€',   'factor' => 0.12,  'flag' => 'eu'],
];

// Moneda actual (por defecto GTQ)
if (!isset($_SESSION['moneda']) || !array_key_exists($_SESSION['moneda'], $monedas)) {
    $_SESSION['moneda'] = 'GTQ';
}

// Función para mostrar precios
function mostrarPrecio($precioBase) {
    global $monedas;
    $moneda = $_SESSION['moneda'];
    $config = $monedas[$moneda];
    $precioConvertido = $precioBase * $config['factor'];
    return $config['simbolo'] . ' ' . number_format($precioConvertido, 2);
}

$monedaSeleccionada = $_SESSION['moneda'] ?? 'GTQ';
$factor = $monedas[$monedaSeleccionada]['factor'];

