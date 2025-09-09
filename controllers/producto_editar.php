<?php
require_once '../includes/db.php';

$id         = $_POST['id'] ?? null;
$nombre     = $_POST['nombre'] ?? '';
$precio     = $_POST['precio'] ?? 0;
$categoria  = $_POST['categoria'] ?? '';
$pais       = $_POST['pais'] ?? '';
$imagenOld  = $_POST['imagen_actual'] ?? '';
$tallas     = $_POST['tallas'] ?? [];

if (!$id || !$nombre || !$precio || !$categoria || !$pais) {
    die('Faltan campos obligatorios');
}

// --- 1) Procesar imagen principal ---
$nombreImagen = $imagenOld;

if (!empty($_FILES['imagen']['name'])) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $nombreImagen = uniqid('img_') . '.' . $ext;
    $rutaDestino = '../uploads/' . $nombreImagen;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        die('Error al subir la nueva imagen principal');
    }

    // Eliminar la anterior
    if ($imagenOld && file_exists('../uploads/' . $imagenOld)) {
        unlink('../uploads/' . $imagenOld);
    }
}

// --- 2) Actualizar datos del producto ---
$sql = "UPDATE productos 
        SET nombre = :nombre, precio = :precio, categoria_id = :categoria, pais_id = :pais, imagen_principal = :imagen 
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nombre'   => $nombre,
    ':precio'   => $precio,
    ':categoria'=> $categoria,
    ':pais'     => $pais,
    ':imagen'   => $nombreImagen,
    ':id'       => $id
]);

// --- 3) Actualizar stock de tallas ---
foreach ($tallas as $tallaId) {
    $campo = 'stock_' . $tallaId;
    $stock = isset($_POST[$campo]) ? (int) $_POST[$campo] : 0;

    // Verificar si ya existe un registro
    $check = $pdo->prepare("SELECT id FROM producto_talla WHERE producto_id = ? AND talla_id = ?");
    $check->execute([$id, $tallaId]);
    $existe = $check->fetch();

    if ($existe) {
        // Update
        $update = $pdo->prepare("UPDATE producto_talla SET stock = ? WHERE producto_id = ? AND talla_id = ?");
        $update->execute([$stock, $id, $tallaId]);
    } else {
        // Insert
        $insert = $pdo->prepare("INSERT INTO producto_talla (producto_id, talla_id, stock) VALUES (?, ?, ?)");
        $insert->execute([$id, $tallaId, $stock]);
    }
}

// --- 4) Eliminar imágenes adicionales seleccionadas ---
if (!empty($_POST['eliminar_imagenes'])) {
    foreach ($_POST['eliminar_imagenes'] as $imgId) {
        // Obtener nombre de archivo
        $stmt = $pdo->prepare("SELECT imagen FROM producto_imagenes WHERE id = ? AND producto_id = ?");
        $stmt->execute([$imgId, $id]);
        $img = $stmt->fetchColumn();

        if ($img && file_exists('../uploads/' . $img)) {
            unlink('../uploads/' . $img);
        }

        // Eliminar de la BD
        $stmt = $pdo->prepare("DELETE FROM producto_imagenes WHERE id = ? AND producto_id = ?");
        $stmt->execute([$imgId, $id]);
    }
}

// --- 5) Subir nuevas imágenes adicionales ---
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
                $stmtImg->execute([$id, $fileName]);
            }
        }
    }
}

header('Location: ../views/admin/productos/index.php');
exit;
