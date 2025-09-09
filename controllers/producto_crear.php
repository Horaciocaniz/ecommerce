<?php
require_once '../includes/db.php';

// Validar campos
$nombre    = $_POST['nombre'] ?? '';
$precio    = $_POST['precio'] ?? 0;
$categoria = $_POST['categoria'] ?? '';
$pais      = $_POST['pais'] ?? '';

if (!$nombre || !$precio || !$categoria || !$pais) {
    die('Faltan campos obligatorios');
}

// --- 1) Subida de imagen principal ---
$nombreImagen = null;

if (!empty($_FILES['imagen']['name'])) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $nombreImagen = uniqid('img_') . '.' . $ext;
    $rutaDestino = '../uploads/' . $nombreImagen;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        die('Error al subir la imagen principal');
    }
}

// --- 2) Insertar producto ---
$sql = "INSERT INTO productos (nombre, precio, categoria_id, pais_id, imagen_principal) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$nombre, $precio, $categoria, $pais, $nombreImagen]);

$producto_id = $pdo->lastInsertId();

// --- 3) Insertar tallas ---
$tallas = $_POST['tallas'] ?? [];

foreach ($tallas as $talla_id) {
    $stock = $_POST['stock_' . $talla_id] ?? 0;

    if ($stock > 0) {
        $stmt = $pdo->prepare("INSERT INTO producto_talla (producto_id, talla_id, stock) VALUES (?, ?, ?)");
        $stmt->execute([$producto_id, $talla_id, $stock]);
    }
}

// --- 4) Subir imágenes adicionales (máx. 5) ---
if (!empty($_FILES['imagenes']['name'][0])) {
    $totalFiles = count($_FILES['imagenes']['name']);
    $maxFiles = min($totalFiles, 5); // máximo 5

    for ($i = 0; $i < $maxFiles; $i++) {
        if ($_FILES['imagenes']['error'][$i] === 0) {
            $ext = pathinfo($_FILES['imagenes']['name'][$i], PATHINFO_EXTENSION);
            $fileName = uniqid('img_') . '.' . $ext;
            $destino  = '../uploads/' . $fileName;

            if (move_uploaded_file($_FILES['imagenes']['tmp_name'][$i], $destino)) {
                $stmtImg = $pdo->prepare("INSERT INTO producto_imagenes (producto_id, imagen) VALUES (?, ?)");
                $stmtImg->execute([$producto_id, $fileName]);
            }
        }
    }
}

// --- 5) Redirigir ---
header('Location: ../views/admin/productos/index.php');
exit;
