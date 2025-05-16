

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}
?>

<div style="padding: 20px; font-family: 'Segoe UI', sans-serif;">
    <style>
        .bienvenida-usuario {
            background-color: #e0f2f1;
            border: 1px solid #81c784;
            padding: 38px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .bienvenida-usuario h2 {
            font-size: 2.5rem;
            color: #388e3c;
            margin-bottom: 40px;
        }
        .bienvenida-usuario p {
            font-size: 1.8rem;
            color: #444;
        }
        .bienvenida-usuario img {
            max-width: 600px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
    </style>

    <?php
    // Comprobar si el usuario o el invitado están en la sesión
    if (isset($_SESSION['usuario'])) {
        // Si es un usuario autenticado
        $nombre = $_SESSION['usuario']['nombre'];
    } elseif (isset($_SESSION['invitado'])) {
        // Si es un invitado autenticado
        $nombre = $_SESSION['invitado']['nombre'];
    } else {
        // Si no hay sesión activa
        $nombre = 'Invitado';
    }
    ?>
    <?php include '../template/encabezado.php'; ?>

    <div class="bienvenida-usuario">
         <h2>¡Bienvenid@, <?php echo htmlspecialchars($nombre); ?>!</h2>
        <p>Desde este panel puedes crear nuevas PQRS, revisar tus solicitudes y responder encuestas de satisfacción.</p>
        <img src="../assets/img/paisaje_kamkuama.jpg.jpg" alt="Bienvenida Usuario" />
    </div>
    <?php include '../template/pie.php'; ?>
</div>
