<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include('../backend/conexion.php');

// Obtener ID y tipo (usuario o invitado)
$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? 'usuario';

if (!$id || !in_array($tipo, ['usuario', 'invitado'])) {
    exit("Parámetros inválidos.");
}

try {
    // Cargar datos según el tipo
    $tabla = $tipo === 'usuario' ? 'usuarios' : 'invitados';
    $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id = ?");
    $stmt->execute([$id]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$datos) {
        exit("Registro no encontrado.");
    }

    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        $update = $pdo->prepare("UPDATE $tabla SET nombre = ?, apellidos = ?, correo = ?, celular = ?, direccion = ? WHERE id = ?");
        $update->execute([$nombre, $apellidos, $correo, $telefono, $direccion, $id]);

        $_SESSION['success'] = 'Información actualizada correctamente.';
        header("Location: usuarios.php");
        exit;
    }
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>

<h2 class="text-center">Editar <?= htmlspecialchars($tipo) ?></h2>

<form method="POST" style="width: 60%; margin: auto;">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required><br><br>

    <label>Apellidos:</label>
    <input type="text" name="apellidos" value="<?= htmlspecialchars($datos['apellidos']) ?>" required><br><br>

    <label>Tipo de Documento:</label>
    <input type="text" value="<?= htmlspecialchars($datos['tipo_documento']) ?>" disabled><br><br>

    <label>Número de Documento:</label>
    <input type="text" value="<?= htmlspecialchars($datos['documento']) ?>" disabled><br><br>

    <label>Correo:</label>
    <input type="email" name="correo" value="<?= htmlspecialchars($datos['correo']) ?>" required><br><br>

    <label>Teléfono (Celular):</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($datos['celular']) ?>" required><br><br>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?= htmlspecialchars($datos['direccion']) ?>" required><br><br>

    <button type="submit">Actualizar</button>
</form>
