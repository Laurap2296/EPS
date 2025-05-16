<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario - KAMKUAMA IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function verificarDocumento() {
            const doc = document.getElementById('documento').value;
            const mensaje = document.getElementById('mensaje_documento');

            if (doc.length === 0) {
                mensaje.textContent = '';
                return;
            }

            fetch('backend/verificar_documento.php?documento=' + encodeURIComponent(doc))
                .then(response => response.json())
                .then(data => {
                    if (data.existe) {
                        mensaje.textContent = '⚠️ Documento ya registrado';
                        mensaje.classList.remove('text-success');
                        mensaje.classList.add('text-danger');
                        document.getElementById('btn_registro').disabled = true;
                    } else {
                        mensaje.textContent = '✅ Documento disponible';
                        mensaje.classList.remove('text-danger');
                        mensaje.classList.add('text-success');
                        document.getElementById('btn_registro').disabled = false;
                    }
                });
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Registro de Usuario</h2>
        <form action="backend/guardar_registro.php" method="POST" class="bg-white p-4 rounded shadow-sm">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Tipo de Documento:</label>
                    <select name="tipo_documento" class="form-control" required>
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="CE">Cédula de Extranjería</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Número de Documento:</label>
                    <input type="text" name="documento" id="documento" class="form-control" onkeyup="verificarDocumento()" required>
                    <small id="mensaje_documento"></small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Celular:</label>
                    <input type="text" name="celular" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Dirección:</label>
                    <input type="text" name="direccion" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Correo:</label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Clave:</label>
                <input type="password" name="clave" class="form-control" required>
            </div>

            <button type="submit" id="btn_registro" class="btn btn-success w-100">Registrarse</button>
        </form>

           </form>

    <!-- Aquí va el bloque de mensajes -->
    <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exito'): ?>
        <div class="alert alert-success mt-3 text-center">
            ✅ Su registro fue exitoso. Ahora puede iniciar sesión.
            <br><br>
            <a href="login.php" class="btn btn-primary mt-2">Iniciar sesión</a>
        </div>
    <?php elseif (isset($_GET['registro']) && $_GET['registro'] === 'duplicado'): ?>
        <div class="alert alert-danger mt-3 text-center">
            ⚠️ El número de documento ya está registrado.
        </div>
    <?php endif; ?>

    <?php include 'template/pie.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
