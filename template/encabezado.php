
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Solo inicia sesión si no está activa
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Kamkuama IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../assets/css/estilos.css"> <!-- Asegúrate de que el archivo esté bien ubicado -->
</head>
<style>
    .navbar {
        background-color: #2e7d32 !important;
    }
    .navbar .nav-link, .navbar-brand {
        color: #fff !important;
    }
    .navbar .nav-link:hover {
        color: #c8e6c9 !important;
        text-decoration: underline;
    }
    .bienvenida {
        margin-top: 50px;
        text-align: center;
        background-color: #e0f2f1;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        font-size: 18px;
    }
    .btn-verde {
        background-color: #388e3c;
        color: white;
    }
    .btn-verde:hover {
        background-color: #66bb6a;
    }
</style>


<!-- Encabezado (Usuario o Funcionario) -->
<header class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../assets/img/logo.jpg" alt="Kamkuama IPS" style="max-width: 120px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
                    <!-- Menú para usuarios -->
                    <li class="nav-item">
                        <a class="nav-link" href="inicio.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="crear_pqrs.php">Crear PQRS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mis_pqrs.php">Mis PQRS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="encuesta.php">Encuesta</a>
                    </li>
                 <?php elseif ($_SESSION['rol'] === 'funcionario'): ?>
                    <li class="nav-item"><a class="nav-link" href="notificaciones.php">Notificaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Gestión Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportes.php">Reportes</a></li>
                    <li class="nav-item"><a class="nav-link" href="ver_pqrs.php">Ver PQRS</a></li>
                    <li class="nav-item"><a class="nav-link" href="responder_pqrs.php">Responder PQRS</a></li>
                    <li class="nav-item"><a class="nav-link" href="ver_encuestas.php">Ver Encuestas</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span class="navbar-text">
                        Bienvenid@, 
                        <?php 
                        if ($_SESSION['rol'] === 'usuario') {
                            echo htmlspecialchars($_SESSION['usuario']['nombre']);
                        } elseif ($_SESSION['rol'] === 'funcionario') {
                            echo htmlspecialchars($_SESSION['funcionario']['nombre']);
                        }
                        ?>
                    </span>
                </li>
                <li class="nav-item"><a class="nav-link" href="../backend/logout.php">Cerrar sesión</a></li>
            </ul>
        </div>
    </div>
</header>