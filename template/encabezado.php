<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../backend/conexion.php';

// Verificar si hay encuestas pendientes SOLO si es usuario o invitado
$hayEncuestaPendiente = false;
$idEncuestaPendiente = null;

if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'usuario' || $_SESSION['rol'] === 'invitado')) {
    $id_usuario = $_SESSION['usuario']['id'];
    $stmt = $pdo->prepare("
        SELECT pq.id
        FROM pqrs pq
        LEFT JOIN respuesta_encuesta re ON pq.id = re.id_pqrs
        WHERE pq.id_emisor = :id_usuario 
        AND pq.respuesta IS NOT NULL
        AND re.id IS NULL
        LIMIT 1
    ");
    $stmt->execute(['id_usuario' => $id_usuario]);
    $encuesta = $stmt->fetch();
    if ($encuesta) {
        $hayEncuestaPendiente = true;
        $idEncuestaPendiente = $encuesta['id'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kamkuama IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../assets/css/estilos.css" />
    <style>
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
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark" style="background-color: #2e7d32;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../assets/img/logo.jpg" alt="Kamkuama IPS" style="max-width: 120px;" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'usuario' || $_SESSION['rol'] === 'invitado')): ?>
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
                        <a class="nav-link <?= $hayEncuestaPendiente ? '' : 'disabled' ?>"
                           href="<?= $hayEncuestaPendiente ? 'encuesta.php?id_pqrs=' . $idEncuestaPendiente : '#' ?>">
                            Encuesta
                            <?php if ($hayEncuestaPendiente): ?>
                                <i class="bi bi-exclamation-circle-fill text-warning"></i>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'funcionario'): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="listar_pqrs.php">Ver PQRS</a></li>
                    <li class="nav-item"><a class="nav-link" href="notificaciones.php">Notificaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios.php">Gestión Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="reportes.php">Reportes</a></li>
                    <li class="nav-item"><a class="nav-link" href="ver_encuestas.php">Ver Encuestas</a></li>
                <?php endif; ?>
            </ul>

<ul class="navbar-nav ms-auto">
    <?php if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['usuario', 'invitado'])): ?>
        <li class="nav-item">
            <span class="navbar-text me-2">
                Bienvenid@, <?= htmlspecialchars($_SESSION['usuario']['nombre'] . ' ' . ($_SESSION['usuario']['apellidos'] ?? '')) ?>
            </span>
        </li>
    <?php endif; ?>




               <?php if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['usuario', 'invitado'])): ?>
    <li class="nav-item">
        <a class="nav-link" href="perfil.php">
            <i class="bi bi-person-circle"></i> Mi perfil
        </a>
    </li>
<?php endif; ?>

<?php if (isset($_SESSION['rol']) && in_array($_SESSION['rol'], ['usuario', 'invitado', 'funcionario'])): ?>
    <li class="nav-item">
        <a class="nav-link" href="../backend/logout.php">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
    </li>
<?php endif; ?>

            </ul>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
