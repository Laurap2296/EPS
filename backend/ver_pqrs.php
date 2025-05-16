<?php
// backend/ver_pqrs.php
session_start();
require_once 'conexion.php';

// Verificamos si hay sesión (funcionario o administrador)
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $pdo->query("SELECT pq.*, us.nombre, us.apellido 
                    FROM pqrs pq
                    JOIN usuarios us ON pq.usuario_id = us.id 
                    ORDER BY pq.fecha_creacion DESC");
$pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver PQRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0fdf0;
        }
        .container {
            margin-top: 30px;
        }
        .table thead {
            background-color: #198754;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #dfffe0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><i class="bi bi-list-check"></i> Lista de PQRS</h3>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pqrs as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= $p['nombre'] . ' ' . $p['apellido'] ?></td>
                        <td><?= $p['tipo'] ?></td>
                        <td><?= $p['motivo'] ?></td>
                        <td><?= $p['fecha_creacion'] ?></td>
                        <td><?= $p['estado'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
