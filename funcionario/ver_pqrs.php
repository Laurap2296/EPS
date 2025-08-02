<?php
session_start();
require_once '../backend/conexion.php';

if (!isset($_SESSION['funcionario']['id']) || $_SESSION['rol'] !== 'funcionario') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de PQRS no especificado.");
}

$pqrs_id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM pqrs WHERE id = :id");
$stmt->execute([':id' => $pqrs_id]);
$pqrs = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pqrs) {
    die("PQRS no encontrada.");
}

include '../template/encabezado.php';
?>

<div class="container mt-4">
    <h2>Detalle PQRS #<?= htmlspecialchars($pqrs['id']) ?></h2>
    <p><strong>Tipo de Solicitud:</strong> <?= htmlspecialchars($pqrs['tipo_solicitud']) ?></p>
    <p><strong>Motivo:</strong> <?= htmlspecialchars($pqrs['motivo']) ?></p>
    <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($pqrs['descripcion'])) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($pqrs['estado']) ?></p>
    <p><strong>Respuesta:</strong><br><?= nl2br(htmlspecialchars($pqrs['respuesta'] ?? 'Sin respuesta aún')) ?></p>
    
    <?php if (!empty($pqrs['respuesta_pdf'])): ?>
        <p><strong>PDF de Respuesta:</strong> 
            <a href="../pdf/<?= htmlspecialchars($pqrs['respuesta_pdf']) ?>" target="_blank">Ver PDF Respuesta</a>
        </p>
    <?php endif; ?>

    <a href="listar_pqrs.php" class="btn btn-secondary">Volver a la lista</a>
</div>

<?php include '../template/pie.php'; ?>
