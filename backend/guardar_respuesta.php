<?php
session_start();
require_once '../backend/conexion.php';
require_once '../backend/generar_pdf_respuesta.php';

// Validar sesión y rol funcionario
if (!isset($_SESSION['funcionario']['id']) || $_SESSION['rol'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

$funcionario_id = $_SESSION['funcionario']['id'];
$funcionario_nombre = $_SESSION['funcionario']['nombre'];

$pqrs_id = $_POST['pqrs_id'] ?? null;
$respuesta = $_POST['respuesta'] ?? '';

if ($pqrs_id && !empty(trim($respuesta))) {
    try {
        // Generar PDF y obtener nombre archivo
        $respuesta_pdf = generarPDFRespuesta($pqrs_id, $respuesta, $funcionario_nombre);

        // Guardar respuesta, PDF y actualizar estado
        $sql = "UPDATE pqrs 
                SET respuesta = :respuesta, 
                    respuesta_pdf = :respuesta_pdf, 
                    id_funcionario = :id_funcionario, 
                    estado = 'respondida' 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':respuesta' => $respuesta,
            ':respuesta_pdf' => $respuesta_pdf,
            ':id_funcionario' => $funcionario_id,
            ':id' => $pqrs_id
        ]);

        header("Location: ver_pqrs.php?success=1");
        exit;

    } catch (Exception $e) {
        // Manejo de error, loguear o mostrar mensaje
        error_log("Error al generar PDF respuesta: " . $e->getMessage());
        header("Location: ver_pqrs.php?error=1");
        exit;
    }
} else {
    // Parámetros inválidos
    header("Location: ver_pqrs.php?error=1");
    exit;
}
