<?php
session_start();
require 'conexion.php';
require 'generar_pdf_pqrs.php'; // Archivo con función para generar PDF individual

$tipo_solicitud = $_POST['tipo_solicitud'];
$motivo = $_POST['motivo'];
$descripcion = $_POST['descripcion'];
$tipo_emisor = $_SESSION['rol']; // 'usuario' o 'invitado'
$usuario = $_SESSION['usuario'];
$id_emisor = $usuario['id'];
$fecha_solicitud = date('Y-m-d H:i:s');
$estado = 'pendiente';

// Subir el archivo de evidencia si existe
$archivo_nombre = '';
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
    $archivo_nombre = time() . '_' . $_FILES['archivo']['name'];
    move_uploaded_file($_FILES['archivo']['tmp_name'], '../uploads/' . $archivo_nombre);
}

// Generar PDF y obtener nombre del archivo
$pdf_nombre = generarPDFPQRS($tipo_solicitud, $motivo, $descripcion, $tipo_emisor, $usuario, $archivo_nombre);

// Insertar en base de datos
$stmt = $pdo->prepare("INSERT INTO pqrs (tipo_solicitud, motivo, descripcion, archivo, fecha_solicitud, estado, tipo_emisor, id_emisor, pdf) 
VALUES (:tipo, :motivo, :descripcion, :archivo, :fecha, :estado, :tipo_emisor, :id_emisor, :pdf)");

$stmt->execute([
    ':tipo' => $tipo_solicitud,
    ':motivo' => $motivo,
    ':descripcion' => $descripcion,
    ':archivo' => $archivo_nombre,
    ':fecha' => $fecha_solicitud,
    ':estado' => $estado,
    ':tipo_emisor' => $tipo_emisor,
    ':id_emisor' => $id_emisor,
    ':pdf' => $pdf_nombre
]);

// Redireccionar con mensaje de éxito
header('Location: ../usuarios/crear_pqrs.php?exito=1');
exit;
?>
