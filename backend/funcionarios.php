<?php
session_start();
require_once 'conexion.php';

if ($_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php"); // Si no es administrador, redirigir al login
    exit;
}

// Función para agregar un funcionario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $email = $_POST['email'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);  // Cifra la contraseña

    $stmt = $pdo->prepare("INSERT INTO funcionarios (nombre, documento, email, clave) 
                            VALUES (:nombre, :documento, :email, :clave)");
    $stmt->execute([
        'nombre' => $nombre,
        'documento' => $documento,
        'email' => $email,
        'clave' => $clave
    ]);
    $mensaje = "Funcionario agregado correctamente";
}

// Listar funcionarios
$stmt = $pdo->prepare("SELECT * FROM funcionarios");
$stmt->execute();
$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Funcionarios - Kamkuama IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Iconos de Bootstrap -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        .table th, .table td {
            text-align: center;
        }
        .header {
            background-color: #1E90FF;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Gestión de Funcionarios - Kamkuama IPS</h2>
</div>

<div class="container mt-4">
    <!-- Mensaje de éxito -->
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <h3>Agregar Funcionario</h3>
        <form action="funcionarios.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="documento" class="form-label">Documento</label>
                <input type="text" name="documento" id="documento" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" name="clave" id="clave" class="form-control" required>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary">Agregar Funcionario</button>
        </form>
    </div>

    <div class="mt-5">
        <h3>Lista de Funcionarios</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td><?php echo $funcionario['nombre']; ?></td>
                        <td><?php echo $funcionario['documento']; ?></td>
                        <td><?php echo $funcionario['email']; ?></td>
                        <td>
                            <a href="editar_funcionario.php?id=<?php echo $funcionario['id']; ?>" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="eliminar_funcionario.php?id=<?php echo $funcionario['id']; ?>" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
