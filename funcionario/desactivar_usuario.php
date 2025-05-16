<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include '../backend/conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de usuario no especificado.";
    header("Location: usuarios.php");
    exit;
}

$id = intval($_GET['id']);

try {
    // Cambiar estado a 0 (inactivo)
    $stmt = $pdo->prepare("UPDATE usuarios SET estado = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $_SESSION['success'] = "Usuario desactivado correctamente.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al desactivar usuario: " . $e->getMessage();
}

header("Location: usuarios.php");
exit;
