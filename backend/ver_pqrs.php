<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['admin']['id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$estadoFiltro = $_GET['estado'] ?? '';

$sql = "SELECT pqrs.*, f.nombre AS funcionario_nombre 
        FROM pqrs 
        LEFT JOIN funcionarios f ON pqrs.id_funcionario = f.id";

$params = [];
if ($estadoFiltro !== '') {
    $sql .= " WHERE pqrs.estado = :estado";
    $params[':estado'] = $estadoFiltro;
}

$sql .= " ORDER BY pqrs.fecha_solicitud DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pqrs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "encabezado.php";
?>

<div class="container mt-4">
    <h2>Lista de PQRS (Administrador)</h2>

    <form method="get" class="mb-3">
        <label for="estado">Filtrar por Estado:</label>
        <select name="estado" id="estado" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
            <option value="">Todos</option>
            <option value="Pendiente" <?= $estadoFiltro=='Pendiente'?'selected':'' ?>>Pendiente</option>
            <option value="Respondida" <?= $estadoFiltro=='Respondida'?'selected':'' ?>>Respondida</option>
        </select>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo Solicitud</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Funcionario</th>
                <th>Fecha</th>
                <th>PDF Usuario</th>
                <th>PDF Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pqrs_list) === 0): ?>
                <tr><td colspan="8" class="text-center">No hay PQRS.</td></tr>
            <?php else: ?>
                <?php foreach ($pqrs_list as $pqrs): ?>
                    <tr>
                        <td><?= htmlspecialchars($pqrs['id']) ?></td>
                        <td><?= htmlspecialchars($pqrs['tipo_solicitud']) ?></td>
                        <td><?= htmlspecialchars($pqrs['motivo']) ?></td>
                        <td><?= htmlspecialchars($pqrs['estado']) ?></td>
                        <td><?= htmlspecialchars($pqrs['funcionario_nombre'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($pqrs['fecha_solicitud']) ?></td>
                        <td>
                            <?php if (!empty($pqrs['pdf'])): ?>
                                <a href="../pdf/<?= htmlspecialchars($pqrs['pdf']) ?>" target="_blank" class="btn btn-secondary btn-sm">Ver PDF</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($pqrs['respuesta_pdf'])): ?>
                                <a href="../pdf/<?= htmlspecialchars($pqrs['respuesta_pdf']) ?>" target="_blank" class="btn btn-success btn-sm">Ver PDF</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
