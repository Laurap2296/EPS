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

    // Para usuarios, la clave debe ser igual al documento (por defecto)
    if ($usuario && $clave === $usuario['documento']) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['rol'] = 'usuario';
        header("Location: http://localhost/eps/usuarios/inicio.php");
        exit();
    }

    // Buscar en tabla invitados
    $stmt = $pdo->prepare("SELECT * FROM invitados WHERE documento = :doc");
    $stmt->execute([':doc' => $documento]);
    $invitado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Para invitados, la clave es la que guardaron (puede estar hasheada)
    if ($invitado && $clave === $invitado['clave']) {
        $_SESSION['usuario'] = $invitado;
        $_SESSION['usuario_id'] = $invitado['id'];
        $_SESSION['rol'] = 'invitado';
        header("Location: http://localhost/eps/usuarios/index.php");
        exit();
    }

    // Si no coincide ninguna
    $_SESSION['error'] = 'Credenciales incorrectas';
    header('Location: http://localhost/eps/login.php');
    exit();
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
