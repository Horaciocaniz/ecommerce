<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Paises</h2>
    <a href="paises_crear.php" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Nuevo País
    </a>

    <?php if (!empty($_GET['mensaje'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'País <?= htmlspecialchars($_GET['mensaje']) ?> correctamente',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($paises as $pais): ?>
                <tr>
                    <td><?= $pais['id'] ?></td>
                    <td><?= $pais['nombre'] ?></td>
                    <td>
                        <a href="paises_editar.php?id=<?= $pais['id'] ?>" class="btn btn-outline-primary btn-sm mb-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="paises_eliminar.php?id=<?= $pais['id'] ?>" 
                           class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('¿Estás seguro de eliminar este país?');">
                            <i class="fas fa-trash"></i> Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../partials/footer.php'; ?>
