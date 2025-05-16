<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conexion.php';

$stmt = $pdo->query("SELECT pqrs.*, u.nombre FROM pqrs 
                     LEFT JOIN usuarios u ON pqrs.id_usuarios = u.id
                     ORDER BY pqrs.fecha DESC");
$pqrs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../template/encabezado.php'; ?>

<div class="container mt-4">
    <h3>PQRS Recibidas</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Asunto</th>
                <th>Fecha</th>
                <th>Ver PQRS</th>
                <th>Ver Respuesta</th>
                <th>Responder</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pqrs_list as $pqrs): ?>
                <tr>
                    <td><?= $pqrs['id'] ?></td>
                    <td><?= htmlspecialchars($pqrs['nombre'] ?? 'Invitado') ?></td>
                    <td><?= htmlspecialchars($pqrs['asunto']) ?></td>
                    <td><?= $pqrs['fecha'] ?></td>
                    <td>
                        <?php if (!empty($pqrs['pdf'])): ?>
                            <a href="../pdf/<?= $pqrs['pdf'] ?>" target="_blank" class="btn btn-success btn-sm">Ver PQRS</a>
                        <?php else: ?>
                            <span class="text-muted">No generado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($pqrs['respuesta_pdf'])): ?>
                            <a href="../respuestas/<?= $pqrs['respuesta_pdf'] ?>" target="_blank" class="btn btn-info btn-sm">Ver Respuesta</a>
                        <?php else: ?>
                            <span class="text-muted">Sin respuesta</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="responder_pqrs.php?id=<?= $pqrs['id'] ?>" class="btn btn-primary btn-sm">Responder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../template/pie.php'; ?>
