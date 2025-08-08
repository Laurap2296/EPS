<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include '../backend/conexion.php';

// Validar id y tipo
if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['tipo']) || empty($_GET['tipo'])) {
    $_SESSION['error'] = "Parámetros inválidos.";
    header("Location: usuarios.php");
    exit;
}

$id = intval($_GET['id']);
$tipo = $_GET['tipo'];

if (!in_array($tipo, ['afiliado', 'invitado'])) {
    $_SESSION['error'] = "Tipo inválido.";
    header("Location: usuarios.php");
    exit;
}

try {
    $tabla = $tipo === 'afiliado' ? 'usuarios' : 'invitados'; // O ajusta 'usuarios' a 'afiliados' si es así tu tabla
    $stmt = $pdo->prepare("UPDATE $tabla SET estado = 0 WHERE id = :id");
    $stmt->execute([':id' => $id]);

    $_SESSION['success'] = ucfirst($tipo) . " desactivado correctamente.";
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al desactivar: " . $e->getMessage();
}

header("Location: usuarios.php");
exit;
