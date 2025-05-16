<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conexion.php';

// Obtener las respuestas de la encuesta
$stmt = $pdo->prepare("SELECT r.*, u.nombre FROM respuesta_encuesta r 
                       JOIN usuarios u ON r.id_usuario = u.id");
$stmt->execute();
$respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respuestas de Encuestas - KAMKUAMA IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../template/encabezado.php'; ?>

    <div class="container mt-5">
        <h2>Respuestas de Encuestas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Resuelta</th>
                    <th>Explicación (Si no fue resuelta)</th>
                    <th>Satisfacción</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respuestas as $respuesta): ?>
                    <tr>
                        <td><?= htmlspecialchars($respuesta['nombre']) ?></td>
                        <td><?= htmlspecialchars($respuesta['resuelta']) ?></td>
                        <td><?= htmlspecialchars($respuesta['explicacion']) ?: 'N/A' ?></td>
                        <td><?= htmlspecialchars($respuesta['satisfaccion']) ?></td>
                        <td><?= htmlspecialchars($respuesta['comentarios']) ?: 'N/A' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include '../template/pie.php'; ?>
</body>
</html>
