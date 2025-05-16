
<?php
session_start();

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Kamkuama IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
    <style>
        body {
            background-color: #e8f5e9;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            max-width: 500px;
            margin: 40px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .nav-tabs .nav-link.active {
            background-color: #388e3c;
            color: white;
        }
        .nav-tabs .nav-link {
            color: #388e3c;
        }
        .btn-login {
            background-color: #388e3c;
            color: white;
        }
        .btn-login:hover {
            background-color: #66bb6a;
        }
    </style>
</head>
<body>
    <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
    <div class="alert alert-success text-center">
        ✅ Su registro fue exitoso. Ahora puede iniciar sesión.
    </div>
<?php endif; ?>


<div class="login-container">
    <h4 class="text-center mb-4">Kamkuama IPS - Gestión de PQRS</h4>
    
    <!-- Tabs para Usuario y Funcionario -->
    <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="usuario-tab" data-bs-toggle="tab" data-bs-target="#usuario" type="button" role="tab">
                Usuario / Invitado
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="funcionario-tab" data-bs-toggle="tab" data-bs-target="#funcionario" type="button" role="tab">
                Funcionario
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Login Usuario -->
        <div class="tab-pane fade show active" id="usuario" role="tabpanel">
            <form action="backend/login_usuario.php" method="POST">
                <div class="mb-3">
                    <label for="documento" class="form-label">Número de Documento</label>
                    <input type="text" class="form-control" name="documento" required>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="clave" required>
                </div>
                <button type="submit" class="btn btn-login w-100">Iniciar sesión</button>
                <div class="text-end mt-2">
                    <a href="registro.php" class="text-success">Registrarse como invitado</a>
                </div>
            </form>
        </div>

        <!-- Login Funcionario -->
        <div class="tab-pane fade" id="funcionario" role="tabpanel">
            <form action="backend/login_funcionario.php" method="POST">
                <div class="mb-3">
                    <label for="documento" class="form-label">Número de Documento</label>
                    <input type="text" class="form-control" name="documento" required>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="clave" required>
                </div>
                <button type="submit" class="btn btn-login w-100">Iniciar sesión</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
