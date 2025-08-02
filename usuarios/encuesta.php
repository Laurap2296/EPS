<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../backend/conexion.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'], ['usuario', 'invitado'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_emisor = $_SESSION['rol'];

$sql = "SELECT p.id
        FROM pqrs p
        LEFT JOIN respuesta_encuesta r ON p.id = r.id_pqrs
        WHERE p.id_emisor = :id_emisor AND p.tipo_emisor = :tipo_emisor
          AND p.estado = 'Respondida' AND r.id IS NULL
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_emisor' => $usuario_id,
    ':tipo_emisor' => $tipo_emisor
]);
$pqrs_pendiente = $stmt->fetch();

if (!$pqrs_pendiente) {
    echo "<div class='alert alert-info m-4'>No tienes encuestas pendientes por responder.</div>";
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
        <h3 class="text-center mb-4">Encuesta de Satisfacción - PQRS #<?php echo htmlspecialchars($pqrs_pendiente['id']); ?></h3>
        <p class="text-center">Por favor, ayúdanos a mejorar nuestros servicios respondiendo esta breve encuesta.</p>

        <?php
        if (isset($_GET['error'])) {
            $msg = '';
            switch ($_GET['error']) {
                case 'datos_invalidos':
                    $msg = 'Faltan datos obligatorios o no son válidos.';
                    break;
                case 'explicacion_requerida':
                    $msg = 'Por favor, explica qué sucedió si la solicitud no fue resuelta.';
                    break;
                case 'error_guardar':
                    $msg = 'Error al guardar la encuesta, inténtalo nuevamente.';
                    break;
                default:
                    $msg = 'Error desconocido.';
            }
            echo "<div class='alert alert-danger'>{$msg}</div>";
        }
        ?>

        <form action="../backend/guardar_encuesta.php" method="POST" class="p-4 border rounded bg-light">

            <input type="hidden" name="id_pqrs" value="<?php echo htmlspecialchars($pqrs_pendiente['id']); ?>">

            <div class="mb-3">
                <label class="form-label">¿Tu solicitud fue resuelta?</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="resuelta" id="resuelta_si" value="Sí" required>
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
                    <option value="" selected disabled>Seleccione...</option>
                    <option value="Muy satisfecho">Muy satisfecho</option>
                    <option value="Satisfecho">Satisfecho</option>
                    <option value="Insatisfecho">Insatisfecho</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios adicionales</label>
                <textarea name="comentarios" id="comentarios" rows="4" class="form-control" placeholder="Escribe aquí tus comentarios..."></textarea>
            </div>

            <button type="submit" class="btn btn-verde">Enviar Encuesta</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="resuelta"]').forEach(function(radio) {
            radio.addEventListener('change', function () {
                const campoExplicacion = document.getElementById('explicacion_no');
                campoExplicacion.style.display = this.value === 'No' ? 'block' : 'none';
                if(this.value === 'Sí') {
                    document.getElementById('explicacion').value = '';
                }
            });
        });
    </script>

    <?php include '../template/pie.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
