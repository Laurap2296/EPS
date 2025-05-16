<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}
include '../template/encabezado.php';
require_once '../backend/conexion.php';

$tipo_emisor = $_SESSION['rol'];
$id_emisor = $_SESSION['usuario']['id'];

// Filtros desde GET
$estado = $_GET['estado'] ?? '';
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$por_pagina = 10;
$inicio = ($pagina - 1) * $por_pagina;

// Construir filtro dinámico
$where = "WHERE tipo_emisor = ? AND id_emisor = ?";
$params = [$tipo_emisor, $id_emisor];

if (!empty($estado)) {
    $where .= " AND estado = ?";
    $params[] = $estado;
}
if (!empty($fecha_inicio)) {
    $where .= " AND fecha_solicitud >= ?";
    $params[] = $fecha_inicio;
}
if (!empty($fecha_fin)) {
    $where .= " AND fecha_solicitud <= ?";
    $params[] = $fecha_fin;
}

// Obtener total de registros
$stmt_total = $pdo->prepare("SELECT COUNT(*) FROM pqrs $where");
$stmt_total->execute($params);
$total_registros = $stmt_total->fetchColumn();
$total_paginas = ceil($total_registros / $por_pagina);

// Agregar LIMIT para paginar
$where .= " ORDER BY fecha_solicitud DESC LIMIT $inicio, $por_pagina";
$stmt = $pdo->prepare("SELECT * FROM pqrs $where");
$stmt->execute($params);
$pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Mis PQRS</h2>

    <form method="get" class="row g-3 mb-3">
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">Todos</option>
                <option value="pendiente" <?= $estado == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="respondido" <?= $estado == 'respondido' ? 'selected' : '' ?>>Respondido</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label">Desde</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= htmlspecialchars($fecha_inicio) ?>">
        </div>
        <div class="col-md-3">
            <label for="fecha_fin" class="form-label">Hasta</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= htmlspecialchars($fecha_fin) ?>">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Ver PQRS</th>
                <th>Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pqrs) === 0): ?>
                <tr><td colspan="6" class="text-center">No se encontraron registros.</td></tr>
            <?php else: ?>
                <?php foreach ($pqrs as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['fecha_solicitud']) ?></td>
                        <td><?= htmlspecialchars($p['tipo_solicitud']) ?></td>
                        <td><?= htmlspecialchars($p['motivo']) ?></td>
                        <td><?= htmlspecialchars($p['estado']) ?></td>
                        <td><a href="../pdf/<?= $p['pdf'] ?>" target="_blank" class="btn btn-sm btn-info">Ver PDF</a></td>
                        <td>
                            <?php if ($p['respuesta_pdf']): ?>
                                <a href="../pdf/<?= $p['respuesta_pdf'] ?>" target="_blank" class="btn btn-sm btn-success">Ver Respuesta</a>
                            <?php else: ?>
                                <span class="text-muted">No respondida</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- PAGINACIÓN -->
    <?php if ($total_paginas > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">Anterior</a>
                    </li>
                <?php endif; ?>

                <li class="page-item disabled"><a class="page-link">Página <?= $pagina ?> de <?= $total_paginas ?></a></li>

                <?php if ($pagina < $total_paginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include '../template/pie.php'; ?>
