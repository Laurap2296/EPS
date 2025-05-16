<?php
session_start();
require_once '../backend/conexion.php';

// Validar sesión funcionario
if (!isset($_SESSION['funcionario']) || $_SESSION['rol'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

$nombre = $_SESSION['funcionario']['nombre'];
?>

<style>
    .bienvenida {
        margin-top: 60px;
        text-align: center;
        background-color: #ffffff;
        border: 1px solid #c8e6c9;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .bienvenida h2 {
        color: #2e7d32;
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .bienvenida p {
        font-size: 1.2rem;
        color: #555;
        margin-bottom: 30px;
    }

    .bienvenida img {
        margin-bottom: 20px;
        max-width: 800px;
        max-height: 300px;
    }

    .btn-verde {
        background-color: #388e3c;
        color: white;
        margin: 5px;
    }

    .btn-verde:hover {
        background-color: #66bb6a;
        color: white;
    }
</style>

<?php include '../template/encabezado.php'; ?>

<div class="container">
    <div class="bienvenida">
        <h2>¡Bienvenid@, <?php echo htmlspecialchars($nombre); ?>!</h2>
       
        <img src="../assets/img/motivacion.jpg" alt="Bienvenido Funcionario" class="img-fluid rounded shadow-sm" style="max-width: 800px; height: 300px;">
        
        <p>"Cada gesto de atención es una luz de esperanza para nuestros usuarios. Gracias por ser parte de Kamkuama IPS."</p>
    </div>
</div>

<?php include '../template/pie.php'; ?>
