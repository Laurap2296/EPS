<?php
require 'conexion.php';

$documento = $_GET['documento'] ?? '';

$stmt = $pdo->prepare("SELECT id FROM invitados WHERE documento = ?");
$stmt->execute([$documento]);
$existe = $stmt->rowCount() > 0;

echo json_encode(['existe' => $existe]);
