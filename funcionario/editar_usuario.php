<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include('../backend/conexion.php');

// Obtener ID y tipo (afiliado o invitado)
$id = $_GET['id'] ?? null;
$tipo = $_GET['tipo'] ?? null;

if (!$id || !in_array($tipo, ['afiliado', 'invitado'])) {
    exit("Parámetros inválidos.");
}

// Mapear tabla correcta
$tabla = $tipo === 'afiliado' ? 'usuarios' : 'invitados';

// Lista de tipos de documento válidos en Colombia
$tiposDocumento = [
    'CC' => 'Cédula de ciudadanía',
    'TI' => 'Tarjeta de identidad',
    'CE' => 'Cédula de extranjería',
    'RC' => 'Registro civil',
    'PA' => 'Pasaporte',
    'PEP' => 'Permiso especial de permanencia'
];

try {
    // Obtener datos actuales
    $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE id = ?");
    $stmt->execute([$id]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$datos) {
        exit("Registro no encontrado.");
    }

    $mensajeExito = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $tipoDocumento = $_POST['tipo_documento'] ?? $datos['tipo_documento'];
        $documento = $_POST['documento'];

        // Validar tipo_documento (opcional)
        if (!array_key_exists($tipoDocumento, $tiposDocumento)) {
            exit("Tipo de documento inválido.");
        }

        $update = $pdo->prepare("UPDATE $tabla SET nombre = ?, apellidos = ?, correo = ?, celular = ?, direccion = ?, tipo_documento = ?, documento = ? WHERE id = ?");
        $update->execute([$nombre, $apellidos, $correo, $telefono, $direccion, $tipoDocumento, $documento, $id]);

        $_SESSION['success'] = 'Información actualizada correctamente.';
        // Recargar la página para mostrar mensaje y evitar resubmision
        header("Location: editar_usuario.php?tipo=$tipo&id=$id");
        exit;
    }
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

?>

<?php include '../template/encabezado.php'; ?>

<style>
form {
    width: 60%;
    margin: 20px auto;
    font-family: Arial, sans-serif;
}
form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
}
form input[type="text"],
form input[type="email"],
form select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
form button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #3498db;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
form button:hover {
    background-color: #2980b9;
}
.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin: 20px auto;
    width: 60%;
    border-radius: 5px;
    border: 1px solid #c3e6cb;
    text-align: center;
}
.success-message a {
    text-decoration: none;
    background-color: #3498db;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    display: inline-block;
    margin-top: 10px;
}
</style>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <br>
        <a href="usuarios.php">Regresar a la lista</a>
    </div>
    <script>
        // Redireccionar automáticamente a lista después de 3 segundos
        setTimeout(() => {
            window.location.href = 'usuarios.php';
        }, 3000);
    </script>
<?php 
    unset($_SESSION['success']);
endif; 
?>

<h2 class="text-center">Editar <?= htmlspecialchars($tipo === 'afiliado' ? 'Afiliado' : 'Invitado') ?></h2>

<form method="POST" autocomplete="off">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>" required>

    <label>Apellidos:</label>
    <input type="text" name="apellidos" value="<?= htmlspecialchars($datos['apellidos']) ?>" required>

    <label>Tipo de Documento:</label>
    <select name="tipo_documento" required>
        <?php foreach ($tiposDocumento as $key => $label): ?>
            <option value="<?= $key ?>" <?= ($datos['tipo_documento'] === $key) ? 'selected' : '' ?>><?= $label ?></option>
        <?php endforeach; ?>
    </select>

    <label>Número de Documento:</label>
    <input type="text" name="documento" value="<?= htmlspecialchars($datos['documento']) ?>" required>

    <label>Correo:</label>
    <input type="email" name="correo" value="<?= htmlspecialchars($datos['correo']) ?>" required>

    <label>Teléfono (Celular):</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($datos['celular']) ?>" required>

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?= htmlspecialchars($datos['direccion']) ?>" required>

    <button type="submit">Actualizar</button>
</form>

<?php include '../template/pie.php'; ?>
