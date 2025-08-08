<?php
session_start();
include("../conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['documento'])) {
    header("Location: ../login.php");
    exit();
}

$documento = $_SESSION['documento'];

// Obtener los datos enviados del formulario
$correo = isset($_POST['correo']) ? mysqli_real_escape_string($conn, $_POST['correo']) : '';
$celular = isset($_POST['celular']) ? mysqli_real_escape_string($conn, $_POST['celular']) : '';
$direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conn, $_POST['direccion']) : '';
$nuevaClave = isset($_POST['clave']) ? mysqli_real_escape_string($conn, $_POST['clave']) : '';

// Verificar si se desea actualizar la clave
if (!empty($nuevaClave)) {
    $claveEncriptada = password_hash($nuevaClave, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET correo = '$correo', celular = '$celular', direccion = '$direccion', clave = '$claveEncriptada' WHERE documento = '$documento'";
} else {
    $sql = "UPDATE usuarios SET correo = '$correo', celular = '$celular', direccion = '$direccion' WHERE documento = '$documento'";
}

if (mysqli_query($conn, $sql)) {
    // Redirigir al perfil con mensaje de éxito
    header("Location: perfil.php?exito=1");
    exit();
} else {
    echo "Error al actualizar el perfil: " . mysqli_error($conn);
}
?>
