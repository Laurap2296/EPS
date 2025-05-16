<?php
require 'conexion.php';

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$tipo_documento = $_POST['tipo_documento'];
$documento = $_POST['documento'];
$celular = $_POST['celular'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];
$clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
$tipo_usuario = 'invitado';
$fecha = date('Y-m-d H:i:s');

// Verificar duplicado por documento
$stmt = $pdo->prepare("SELECT id FROM invitados WHERE documento = ?");
$stmt->execute([$documento]);
if ($stmt->rowCount() > 0) {
    header('Location: ../registro.php?registro=duplicado');
    exit;
}

// Insertar
$stmt = $pdo->prepare("INSERT INTO invitados (nombre, apellidos, tipo_documento, documento, celular, direccion, correo, tipo_usuario, fecha_registro, clave)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$nombre, $apellidos, $tipo_documento, $documento, $celular, $direccion, $correo, $tipo_usuario, $fecha, $clave]);

header('Location: ../registro.php?registro=exito');
exit;
