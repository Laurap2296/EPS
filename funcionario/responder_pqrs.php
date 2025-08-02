<?php
session_start();
require_once '../backend/conexion.php';
require_once '../backend/generar_pdf_respuesta.php';

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

$funcionario_id = $_SESSION['funcionario']['id'];
$funcionario_nombre = $_SESSION['funcionario']['nombre'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta = trim($_POST['respuesta'] ?? '');

    if ($respuesta === '') {
        $error = "Debe escribir una respuesta.";
    } else {
        $respuesta_pdf = generarPDFRespuesta($pqrs_id, $respuesta, $funcionario_nombre);

        $sql = "UPDATE pqrs SET respuesta = :respuesta, respuesta_pdf = :respuesta_pdf, id_funcionario = :id_funcionario, estado = 'Respondida' WHERE id = :id";
        $stmt2 = $pdo->prepare($sql);
        $stmt2->execute([
            ':respuesta' => $respuesta,
            ':respuesta_pdf' => $respuesta_pdf,
            ':id_funcionario' => $funcionario_id,
            ':id' => $pqrs_id
        ]);

        $success = "Respuesta guardada correctamente.";

        // Actualizar datos para mostrar respuesta ya guardada
        $pqrs['respuesta'] = $respuesta;
        $pqrs['respuesta_pdf'] = $respuesta_pdf;
        $pqrs['estado'] = 'Respondida';
    }
}

include "../template/encabezado.php";
?>

<div class="container mt-4">
    <h2>Responder PQRS #<?= htmlspecialchars($pqrs['id']) ?></h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <p><strong>Tipo de Solicitud:</strong> <?= htmlspecialchars($pqrs['tipo_solicitud']) ?></p>
    <p><strong>Motivo:</strong> <?= htmlspecialchars($pqrs['motivo']) ?></p>
    <p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($pqrs['descripcion'])) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($pqrs['estado']) ?></p>

    <form method="post" action="">
        <div class="mb-3">
            <label for="respuesta" class="form-label">Respuesta del Funcionario:</label>
            <textarea name="respuesta" id="respuesta" rows="6" class="form-control" required><?= htmlspecialchars($pqrs['respuesta'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Respuesta</button>
        <a href="listar_pqrs.php" class="btn btn-secondary">Volver</a>
    </form>

    <?php if (!empty($pqrs['respuesta_pdf'])): ?>
        <p class="mt-3">
            <strong>PDF de Respuesta:</strong> 
            <a href="../pdf/<?= htmlspecialchars($pqrs['respuesta_pdf']) ?>" target="_blank" rel="noopener noreferrer">Ver PDF Respuesta</a>
        </p>
    <?php endif; ?>
</div>

<?php include '../template/pie.php'; ?>
