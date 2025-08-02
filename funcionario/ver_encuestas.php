<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conexion.php';

$sql = "
    SELECT 
        r.*,
        CASE
            WHEN r.tipo_emisor = 'usuario' THEN u.nombre
            WHEN r.tipo_emisor = 'invitado' THEN i.nombre
            ELSE 'Desconocido'
        END AS nombre,
        CASE
            WHEN r.tipo_emisor = 'usuario' THEN 'Usuario'
            WHEN r.tipo_emisor = 'invitado' THEN 'Invitado'
            ELSE 'Desconocido'
        END AS tipo_emisor
    FROM respuesta_encuesta r
    LEFT JOIN usuarios u ON r.id_emisor = u.id
    LEFT JOIN invitados i ON r.id_emisor = i.id
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en consulta SQL: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Respuestas de Encuestas - KAMKUAMA IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <?php include '../template/encabezado.php'; ?>

    <div class="container mt-5">
        <h2>Respuestas de Encuestas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>¿Fue resuelta?</th>
                    <th>Explicación (Si no fue resuelta)</th>
                    <th>Satisfacción</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($respuestas)): ?>
                    <?php foreach ($respuestas as $respuesta): ?>
                        <tr>
                            <td><?= htmlspecialchars($respuesta['nombre'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($respuesta['tipo_emisor'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($respuesta['resuelta'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($respuesta['explicacion'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($respuesta['satisfaccion'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($respuesta['comentarios'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay respuestas para mostrar.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include '../template/pie.php'; ?>
</body>
</html>
