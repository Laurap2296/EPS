<?php
session_start();
require_once '../backend/conexion.php';

if (!isset($_SESSION['funcionario']['id']) || $_SESSION['rol'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

include '../template/encabezado.php';

// Consultar todas las PQRS ordenadas por fecha descendente
$stmt = $pdo->prepare("SELECT * FROM pqrs ORDER BY fecha_solicitud DESC");
$stmt->execute();
$pqrs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Listado de PQRS</h2>
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Solicitud</th>
                <th>Motivo</th>
                <th>Fecha Solicitud</th>
                <th>Estado</th>
                <th>PDF Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pqrs_list as $pqrs): ?>
            <tr>
                <td><?= htmlspecialchars($pqrs['id']) ?></td>
                <td><?= htmlspecialchars($pqrs['tipo_solicitud']) ?></td>
                <td><?= htmlspecialchars($pqrs['motivo']) ?></td>
                <td><?= htmlspecialchars($pqrs['fecha_solicitud']) ?></td>
                <td><?= htmlspecialchars($pqrs['estado']) ?></td>

                <td>
                    <?php if (!empty($pqrs['pdf'])): ?>
                        <a href="../pdf/<?= htmlspecialchars($pqrs['pdf']) ?>" target="_blank" class="btn btn-secondary btn-sm">Ver PDF Usuario</a>
                    <?php else: ?>
                        <span class="text-muted">No disponible</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if (trim(strtolower($pqrs['estado'])) !== 'respondida'): ?>
                        <a href="responder_pqrs.php?id=<?= $pqrs['id'] ?>" class="btn btn-success btn-sm">Responder</a>
                    <?php else: ?>
                        <?php if (!empty($pqrs['respuesta_pdf'])): ?>
                            <a href="../pdf/<?= htmlspecialchars($pqrs['respuesta_pdf']) ?>" target="_blank" class="btn btn-info btn-sm">Ver PDF Respuesta</a>
                        <?php else: ?>
                            <span class="text-muted">Respuesta PDF no disponible</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../template/pie.php'; ?>
