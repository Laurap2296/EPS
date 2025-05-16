<?php
session_start();
require_once '../backend/conexion.php';
require_once '../backend/generar_pdf_respuesta.php';

if (!isset($_SESSION['usuario']['id']) || $_SESSION['rol'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

$funcionario_id = $_SESSION['usuario']['id'];
$funcionario_nombre = $_SESSION['usuario']['nombre'];
$pqrs_id = $_POST['pqrs_id'] ?? null;
$respuesta = $_POST['respuesta'] ?? '';

if ($pqrs_id && $respuesta) {
    // Generar el PDF
    $respuesta_pdf = generarPDFRespuesta($pqrs_id, $respuesta, $funcionario_nombre);

    // Guardar en la base de datos
    $sql = "UPDATE pqrs SET respuesta = :respuesta, respuesta_pdf = :respuesta_pdf, id_funcionario = :id_funcionario, estado = 'Respondida' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':respuesta' => $respuesta,
        ':respuesta_pdf' => $respuesta_pdf,
        ':id_funcionario' => $funcionario_id,
        ':id' => $pqrs_id
    ]);

    header("Location: ver_pqrs.php?success=1");
    exit;
} else {
    header("Location: ver_pqrs.php?error=1");
    exit;
}
?>
