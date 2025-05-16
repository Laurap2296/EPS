<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    die("No autorizado.");
}

require_once 'conexion.php';

$tipo = $_GET['tipo_solicitud'] ?? 'Todas';
$mes = $_GET['mes'] ?? 'Todos';
$anio = $_GET['anio'] ?? 'Todos';

$condiciones = [];
$params = [];

if ($tipo !== 'Todas') {
    $condiciones[] = 'tipo_solicitud = :tipo';
    $params[':tipo'] = $tipo;
}
if ($mes !== 'Todos') {
    $condiciones[] = 'MONTH(fecha_solicitud) = :mes';
    $params[':mes'] = $mes;
}
if ($anio !== 'Todos') {
    $condiciones[] = 'YEAR(fecha_solicitud) = :anio';
    $params[':anio'] = $anio;
}

$whereSQL = '';
if ($condiciones) {
    $whereSQL = ' WHERE ' . implode(' AND ', $condiciones);
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=reporte_pqrs_encuestas.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<h2>Reporte PQRS</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Tipo Solicitud</th><th>Motivo</th><th>Fecha Solicitud</th><th>Estado</th></tr>";

$stmt = $pdo->prepare("SELECT id, tipo_solicitud, motivo, fecha_solicitud, estado FROM pqrs $whereSQL ORDER BY fecha_solicitud DESC");
$stmt->execute($params);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['tipo_solicitud']) . "</td>";
    echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha_solicitud']) . "</td>";
    echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><h2>Reporte Encuestas</h2>";
echo "<table border='1'>";
echo "<tr><th>ID Encuesta</th><th>Calificación</th><th>Fecha Encuesta</th></tr>";

$sqlEnc = "SELECT id, calificacion, fecha_encuesta FROM encuestas ORDER BY fecha_encuesta DESC";
$stmt2 = $pdo->query($sqlEnc);
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['calificacion']) . "</td>";
    echo "<td>" . htmlspecialchars($row['fecha_encuesta']) . "</td>";
    echo "</tr>";
}
echo "</table>";

exit;
?>
