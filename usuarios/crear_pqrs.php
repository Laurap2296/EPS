<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
include '../template/encabezado.php';  // Incluye el encabezado que ya tienes
?>

<div class="container mt-5">
    <h2>Crear PQRS</h2>
    <form action="../backend/guardar_pqrs.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tipo_solicitud" class="form-label">Tipo de Solicitud</label>
            <select class="form-control" name="tipo_solicitud" id="tipo_solicitud" required>
                <option value="Consulta">Consulta</option>
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

<?php include '../template/pie.php';  // Incluye el pie de página ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               