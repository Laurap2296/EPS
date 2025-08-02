<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'], ['usuario', 'invitado'])) {
    header("Location: ../login.php");
    exit;
}

// Validar que los datos necesarios vienen en POST
if (
    !isset($_POST['id_pqrs'], $_POST['resuelta'], $_POST['satisfaccion']) ||
    empty($_POST['id_pqrs']) ||
    empty($_POST['resuelta']) ||
    empty($_POST['satisfaccion'])
) {
    header("Location: ../usuarios/encuesta.php?error=datos_invalidos");
    exit;
}

$id_pqrs = $_POST['id_pqrs'];
$resuelta = $_POST['resuelta'];
$satisfaccion = $_POST['satisfaccion'];
$comentarios = $_POST['comentarios'] ?? null;
$explicacion = $_POST['explicacion'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

// Validar que la explicación se envíe si resuelta es "No"
if ($resuelta === 'No' && (empty(trim($explicacion)))) {
    header("Location: ../usuarios/encuesta.php?error=explicacion_requerida");
    exit;
}

// Si la solicitud fue resuelta, ignoramos explicación
if ($resuelta === 'Sí') {
    $explicacion = null;
}

// Verificar si ya existe encuesta para esta PQRS y usuario (evitar duplicados)
$sqlCheck = "SELECT id FROM respuesta_encuesta WHERE id_pqrs = :id_pqrs AND id_usuario = :id_usuario";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([':id_pqrs' => $id_pqrs, ':id_usuario' => $usuario_id]);
if ($stmtCheck->rowCount() > 0) {
    // Ya respondida, redirigir o mostrar mensaje
    header("Location: ../usuarios/mis_pqrs.php?mensaje=encuesta_ya_respondida");
    exit;
}

// Insertar encuesta
$sql = "INSERT INTO respuesta_encuesta (id_pqrs, id_usuario, resuelta, explicacion, satisfaccion, comentarios, fecha_respuesta)
        VALUES (:id_pqrs, :id_usuario, :resuelta, :explicacion, :satisfaccion, :comentarios, NOW())";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    ':id_pqrs' => $id_pqrs,
    ':id_usuario' => $usuario_id,
    ':resuelta' => $resuelta,
    ':explicacion' => $explicacion,
    ':satisfaccion' => $satisfaccion,
    ':comentarios' => $comentarios
]);

if ($result) {
    // Éxito, redirigir a encuesta_exito.php
    header("Location: ../usuarios/encuesta_exito.php");
    exit;
} else {
    // Error al guardar
    header("Location: ../usuarios/encuesta.php?error=error_guardar");
    exit;
}
