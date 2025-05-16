<?php
session_start();
require_once 'conexion.php';

$documento = $_POST['documento'] ?? '';
$clave = $_POST['clave'] ?? '';

try {
    // Buscar en tabla usuarios
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE documento = :doc");
    $stmt->execute([':doc' => $documento]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $clave === $usuario['documento']) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuario_id'] = $usuario['id']; // 👈 ESTA LÍNEA ES CLAVE
        $_SESSION['rol'] = 'usuario';
        header("Location: http://localhost/eps/usuarios/inicio.php");
        exit();
    }

    // Buscar en tabla invitados
    $stmt = $pdo->prepare("SELECT * FROM invitados WHERE documento = :doc");
    $stmt->execute([':doc' => $documento]);
    $invitado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($invitado && $clave === $invitado['documento']) {
        $_SESSION['usuario'] = $invitado;
        $_SESSION['usuario_id'] = $invitado['id']; // 👈 TAMBIÉN AQUÍ
        $_SESSION['rol'] = 'invitado';
        header("Location: http://localhost/eps/usuarios/index.php");
        exit();
    }

    // Si no coincide
    $_SESSION['error'] = 'Credenciales incorrectas';
    header('Location: http://localhost/eps/login.php');
    exit();
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
