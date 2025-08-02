<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
include '../template/encabezado.php';
?>

<div class="container mt-5">
    <h2>Crear PQRS</h2>

    <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ¡Su PQRS fue creada con éxito!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <form action="../backend/guardar_pqrs.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tipo_solicitud" class="form-label">Tipo de Solicitud</label>
            <select class="form-control" name="tipo_solicitud" id="tipo_solicitud" required>
                <option value="peticion">Petición</option>
                <option value="Queja">Queja</option>
                <option value="Sugerencia">Sugerencia</option>
                <option value="Reclamo">Reclamo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" name="motivo" id="motivo" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="archivo" class="form-label">Adjuntar Evidencia (Imagen)</label>
            <input type="file" class="form-control" name="archivo" id="archivo" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Crear PQRS</button>
    </form>
</div>

<?php include '../template/pie.php'; ?>

<!-- Script opcional para ocultar el mensaje después de 4 segundos -->
<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 4000);
</script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     