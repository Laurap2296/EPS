<?php
// backend/exportar_excel.php
require_once 'conexion.php';

// Consulta datos para PQRS
$stmt = $pdo->prepare("SELECT tipo_solicitud AS tipo, COUNT(*) AS cantidad FROM pqrs GROUP BY tipo_solicitud");
$stmt->execute();
$pqrs_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta datos para Encuesta
$stmt2 = $pdo->prepare("SELECT satisfaccion, COUNT(*) AS cantidad FROM respuesta_encuesta GROUP BY satisfaccion");
$stmt2->execute();
$encuesta_data = $stmt2->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reportes_pqrs_encuesta.xls");

echo "<table border='1'>";
echo "<tr><th colspan='2'>Tabla PQRS por Tipo</th></tr>";
echo "<tr><th>Tipo</th><th>Cantidad</th></tr>";
foreach($pqrs_data as $row){
    echo "<tr><td>{$row['tipo']}</td><td>{$row['cantidad']}</td></tr>";
}
echo "</table><br>";

echo "<table border='1'>";
echo "<tr><th colspan='2'>Tabla de Encuestas por Satisfacción</th></tr>";
echo "<tr><th>Satisfacción</th><th>Cantidad</th></tr>";
foreach($encuesta_data as $row){
    echo "<tr><td>{$row['satisfaccion']}</td><td>{$row['cantidad']}</td></tr>";
}
echo "</table>";
