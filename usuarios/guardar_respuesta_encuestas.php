<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
?>

require_once '../backend/conexion.php';

if ($_SESSION['rol'] !== 'usuario') {
    header("Location: ../login.php");
    exit();
}
include '../template/encabezado.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_SESSION['usuario']['documento'];
    $respuesta = $_POST['respuesta'];

    try {
        // Guardar la respuesta en la base de datos
        $stmt = $pdo->prepare("INSERT INTO respuestas_encuesta (documento_usuario, respuesta) VALUES (:doc, :respuesta)");
        $stmt->execute([':doc' => $documento, ':respuesta' => $respuesta]);

        $_SESSION['success'] = 'Respuesta registrada exitosamente.';
        header("Location: mis_pqrs.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al guardar la respuesta.';
    }
}
?>

<!-- Formulario para responder la encuesta -->
<form method="POST">
    <textarea name="respuesta" required></textarea>
    <button type="submit">Enviar Respuesta</button>
</form>
