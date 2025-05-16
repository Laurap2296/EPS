<?php

require_once '../backend/conexion.php';
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

$id_pqrs = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM pqrs WHERE id = ?");
$stmt->execute([$id_pqrs]);
$pqrs = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include '../template/encabezado.php'; ?>
<div class="container mt-4">
    <h2>Responder PQRS #<?= $id_pqrs ?></h2>
    <form action="../backend/guardar_respuesta.php" method="POST">
        <input type="hidden" name="id_pqrs" value="<?= $id_pqrs ?>">
        <div class="mb-3">
            <label>Respuesta</label>
            <textarea name="respuesta" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
    </form>
</div>
<?php include '../template/pie.php'; ?>
