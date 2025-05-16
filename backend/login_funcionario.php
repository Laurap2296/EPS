<?php
// archivo: backend/login_funcionario.php
session_start();
require_once 'conexion.php';

$documento = $_POST['documento'] ?? '';
$clave = $_POST['clave'] ?? '';

try {
    // Consulta para verificar las credenciales del funcionario
    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE documento = :doc");
    $stmt->execute([':doc' => $documento]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el funcionario existe y la clave es correcta
    if ($funcionario && $clave === 'Funcionario123') {
        // Guardar sesión correctamente como 'funcionario'
        $_SESSION['funcionario'] = $funcionario;
        $_SESSION['rol'] = 'funcionario';

        // Redirigir al panel de funcionario
        header('Location: ../funcionario/index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Credenciales inválidas';
        header("Location: ../login.php");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'Ocurrió un error: ' . $e->getMessage();
    header("Location: ../login.php");
    exit;
}
