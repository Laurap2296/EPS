<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include('../backend/conexion.php');


// Parámetros de paginación y filtro
$letra = isset($_GET['letra']) ? $_GET['letra'] : '';
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$porPagina = 10;
$inicio = ($pagina - 1) * $porPagina;

// Construir WHERE
$where = "";
$params = [];

if (!empty($letra)) {
    $where = "WHERE nombre LIKE :letra";
    $params[':letra'] = $letra . '%';
}

// Obtener total de usuarios e invitados
$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM (
    SELECT id, nombre, apellidos, tipo_documento, documento, correo, celular, 'usuario' AS tipo FROM usuarios
    UNION ALL
    SELECT id, nombre, apellidos, tipo_documento, documento, correo, celular, 'invitado' AS tipo FROM invitados
) AS todos $where");
$totalQuery->execute($params);
$totalRegistros = $totalQuery->fetchColumn();

$totalPaginas = ceil($totalRegistros / $porPagina);

// Obtener usuarios e invitados con paginación
$sql = "SELECT * FROM (
    SELECT id, nombre, apellidos, tipo_documento, documento, correo, celular, 'usuario' AS tipo FROM usuarios
    UNION ALL
    SELECT id, nombre, apellidos, tipo_documento, documento, correo, celular, 'invitado' AS tipo FROM invitados
) AS todos $where ORDER BY nombre ASC LIMIT $inicio, $porPagina";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../template/encabezado.php'; ?>

<style>
.table-usuarios {
    width: 95%;
    margin: 20px auto;
    border-collapse: collapse;
}
.table-usuarios th, .table-usuarios td {
    padding: 10px;
    border: 1px solid #ccc;
}
.table-usuarios th {
    background-color: #f2f2f2;
}
.table-usuarios tr:nth-child(even) {
    background-color: #f9f9f9;
}
.table-usuarios tr:hover {
    background-color: #f1f1f1;
}
.boton-editar, .boton-desactivar {
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    color: white;
}
.boton-editar {
    background-color: #3498db;
}
.boton-editar:hover {
    background-color: #2980b9;
}
.boton-desactivar {
    background-color: #e74c3c;
}
.boton-desactivar:hover {
    background-color: #c0392b;
}
.filtro-letras {
    text-align: center;
    margin: 20px 0;
}
.filtro-letras a {
    margin: 0 5px;
    text-decoration: none;
    font-weight: bold;
    color: #2c3e50;
}
</style>

<h2 class="text-center">Gestión de Usuarios e Invitados</h2>

<div class="filtro-letras">
    Filtrar por letra:
    <?php foreach (range('A', 'Z') as $l): ?>
        <a href="?letra=<?= $l ?>"><?= $l ?></a>
    <?php endforeach; ?>
    <a href="usuarios.php">[Todos]</a>
</div>

<table class="table-usuarios">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Tipo Documento</th>
            <th>Documento</th>
            <th>Correo</th>
            <th>Celular</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo_documento']) ?></td>
                    <td><?= htmlspecialchars($usuario['documento']) ?></td>
                    <td><?= htmlspecialchars($usuario['correo']) ?></td>
                    <td><?= htmlspecialchars($usuario['celular']) ?></td>
                    <td><?= ucfirst($usuario['tipo']) ?></td>
                   <td>
    <div style="display: flex; gap: 10px;">
        <a class="boton-editar" href="editar_usuario.php?tipo=<?= $usuario['tipo'] ?>&id=<?= $usuario['id'] ?>">Editar</a>
        <a class="boton-desactivar" href="desactivar_usuario.php?tipo=<?= $usuario['tipo'] ?>&id=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de desactivar este usuario?')">Desactivar</a>
    </div>
</td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No se encontraron usuarios o invitados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 20px;">
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?pagina=<?= $i ?>&letra=<?= $letra ?>" style="margin: 0 5px;"><?= $i ?></a>
    <?php endfor; ?>
</div>

<?php include '../template/pie.php'; ?>
