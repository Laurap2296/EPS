<?php
// backend/index.php
session_start();

$nombre_usuario = $_SESSION['nombre'] ?? 'Invitado';
$rol = $_SESSION['rol'] ?? 'funcionario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Backend</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e0fbe0;
            font-family: sans-serif;
        }
        .bienvenida {
            margin-top: 60px;
            text-align: center;
            color: #155724;
        }
        .bienvenida h1 {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="container bienvenida">
        <h1>Bienvenido, <?= htmlspecialchars($nombre_usuario) ?></h1>
        <p class="lead">Estás en el panel de gestión de PQRS - Rol: <?= $rol ?></p>
    </div>
</body>
</html>
