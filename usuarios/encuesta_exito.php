<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta Enviada - KAMKUAMA IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../template/encabezado.php'; ?>

    <div class="container mt-5">
        <h2>¡Gracias por tu participación!</h2>
        <p>Tu encuesta ha sido enviada exitosamente. Apreciamos tus comentarios para mejorar nuestros servicios.</p>
        <a href="../usuarios/inicio.php" class="btn btn-primary">Volver al inicio</a>
    </div>

    <?php include '../template/pie.php'; ?>
</body>
</html>
