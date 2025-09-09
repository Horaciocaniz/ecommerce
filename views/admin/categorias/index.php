<?php include_once __DIR__ . '/../partials/header.php'; ?>
<div class="container mt-4">
    <h2>Categorías</h2>
    <a href="categorias_crear.php" class="btn btn-success mb-3">+ Nueva Categoría</a>
    
    <?php if (!empty($_GET['mensaje'])): ?>
        <div class="alert alert-info">Categoría <?= htmlspecialchars($_GET['mensaje']) ?> correctamente</div>
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
            <?php foreach($categorias as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= $cat['nombre'] ?></td>
                    <td>
                        <a href="categorias_editar.php?id=<?= $cat['id'] ?>" 
                        class="btn btn-outline-primary btn-sm mb-1">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <button type="button" 
                                class="btn btn-outline-danger btn-sm btn-eliminar"
                                data-id="<?= $cat['id'] ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const botonesEliminar = document.querySelectorAll(".btn-eliminar");

    botonesEliminar.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");

            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡Esta acción no se puede deshacer!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `categorias_eliminar.php?id=${id}`;
                }
            });
        });
    });
});
</script>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
