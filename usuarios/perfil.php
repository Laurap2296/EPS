<?php
session_start();
require_once '../template/encabezado.php';
require_once '../backend/conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario']['id'];

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT nombre, apellidos, tipo_documento, documento, celular, direccion, correo FROM usuarios WHERE id = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $celular = $_POST["celular"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["correo"];
    $clave = !empty($_POST["clave"]) ? password_hash($_POST["clave"], PASSWORD_DEFAULT) : null;

    if ($clave) {
        $sql = "UPDATE usuarios SET celular = ?, direccion = ?, correo = ?, clave = ? WHERE id = ?";
        $params = [$celular, $direccion, $correo, $clave, $id_usuario];
    } else {
        $sql = "UPDATE usuarios SET celular = ?, direccion = ?, correo = ? WHERE id = ?";
        $params = [$celular, $direccion, $correo, $id_usuario];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Actualizar sesión
    $_SESSION['usuario']['celular'] = $celular;
    $_SESSION['usuario']['direccion'] = $direccion;
    $_SESSION['usuario']['correo'] = $correo;

    $mensaje = "Perfil actualizado exitosamente.";
}
?>

<div class="container mt-5">
    <h2>Mi Perfil</h2>

    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Apellidos:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['apellidos']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Tipo de Documento:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['tipo_documento']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Número de Documento:</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['documento']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label>Celular:</label>
            <input type="text" name="celular" class="form-control" value="<?= htmlspecialchars($usuario['celular']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Dirección:</label>
            <input type="text" name="direccion" class="form-control" value="<?= htmlspecialchars($usuario['direccion']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Correo:</label>
            <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Contraseña (dejar en blanco si no desea cambiarla):</label>
            <input type="password" name="clave" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar cambios</button>
    </form>
</div>

<?php include '../template/pie.php'; ?>
