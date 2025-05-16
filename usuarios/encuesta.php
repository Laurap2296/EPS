<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta de Satisfacción - KAMKUAMA IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
        }
        .form-encuesta {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .btn-verde {
            background-color: #198754;
            color: white;
        }
        .btn-verde:hover {
            background-color: #45b36b;
        }
    </style>
</head>
<body>
    <?php include '../template/encabezado.php'; ?>
    <div class="form-encuesta">
        <h3 class="text-center mb-4">Encuesta de Satisfacción</h3>
        <p class="text-center">Por favor, ayúdanos a mejorar nuestros servicios respondiendo esta breve encuesta.</p>
          <form action="../backend/guardar_encuesta.php" method="POST" class="p-4 border rounded bg-light">

    <div class="mb-3">
        <label class="form-label">¿Tu solicitud fue resuelta?</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="resuelta" id="resuelta_si" value="Si" required>
            <label class="form-check-label" for="resuelta_si">Sí</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="resuelta" id="resuelta_no" value="No">
            <label class="form-check-label" for="resuelta_no">No</label>
        </div>
    </div>

    <div class="mb-3" id="explicacion_no" style="display: none;">
        <label for="explicacion" class="form-label">Si no fue resuelta, ¿qué sucedió?</label>
        <input type="text" name="explicacion" id="explicacion" class="form-control">
    </div>

    <div class="mb-3">
        <label for="satisfaccion" class="form-label">¿Qué tan satisfecho está con la atención?</label>
        <select name="satisfaccion" id="satisfaccion" class="form-control" required>
            <option value="Muy satisfecho">Muy satisfecho</option>
            <option value="Satisfecho">Satisfecho</option>
            <option value="Insatisfecho">Insatisfecho</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="comentarios" class="form-label">Comentarios adicionales</label>
        <textarea name="comentarios" id="comentarios" rows="4" class="form-control" placeholder="Escribe aquí tus comentarios..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
</form>

    </div>
    <script>
document.querySelectorAll('input[name="resuelta"]').forEach(function(radio) {
    radio.addEventListener('change', function () {
        const campoExplicacion = document.getElementById('explicacion_no');
        campoExplicacion.style.display = this.value === 'No' ? 'block' : 'none';
    });
});
</script>
    <?php include '../template/pie.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
