<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$resuelta = $_POST['resuelta'];
$explicacion = $_POST['explicacion'] ?? null;
$satisfaccion = $_POST['satisfaccion'];
$comentarios = $_POST['comentarios'];

// Insertar en la base de datos
$stmt = $pdo->prepare("INSERT INTO respuesta_encuesta (id_usuario, resuelta, explicacion, satisfaccion, comentarios) 
VALUES (:id_usuario, :resuelta, :explicacion, :satisfaccion, :comentarios)");
$stmt->execute([
    ':id_usuario' => $usuario_id,
    ':resuelta' => $resuelta,
    ':explicacion' => $explicacion,
    ':satisfaccion' => $satisfaccion,
    ':comentarios' => $comentarios,
]);

// Verificar el rol
$rol = $_SESSION['rol']; // 'usuario' o 'funcionario'

// Si es un usuario, redirigir a la página de confirmación
if ($rol === 'usuario') {
    header('Location: ../usuarios/encuesta_exito.php');
} else {
    // Si es un funcionario, redirigir a la página de respuestas de encuesta
    header('Location: ../funcionarios/ver_encuestas.php');
}
exit;
?>
