<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

require_once '../backend/conexion.php';

// Recibir filtros
$tipo = $_POST['tipo_solicitud'] ?? 'Todas';
$mes = $_POST['mes'] ?? 'Todos';
$anio = $_POST['anio'] ?? 'Todos';

// Función para armar condiciones SQL
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

// Datos PQRS para tabla
$sqlPQRS = "SELECT id, tipo_solicitud, motivo, fecha_solicitud, estado FROM pqrs $whereSQL ORDER BY fecha_solicitud DESC";
$stmt = $pdo->prepare($sqlPQRS);
$stmt->execute($params);
$pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Datos para gráfico PQRS (cantidad por tipo)
$sqlGraficoPQRS = "SELECT tipo_solicitud, COUNT(*) as cantidad FROM pqrs $whereSQL GROUP BY tipo_solicitud";
$stmt2 = $pdo->prepare($sqlGraficoPQRS);
$stmt2->execute($params);
$datosGrafPQRS = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$tipos = [];
$cantidadesPQRS = [];
foreach ($datosGrafPQRS as $fila) {
    $tipos[] = $fila['tipo_solicitud'];
    $cantidadesPQRS[] = (int)$fila['cantidad'];
}

// Datos encuestas para tabla (filtrado por fecha de encuesta similar a pqrs)
$whereEncuestaSQL = '';
$paramsEncuesta = [];

if ($mes !== 'Todos') {
    $whereEncuestaSQL .= ($whereEncuestaSQL ? ' AND ' : ' WHERE ') . 'MONTH(fecha_encuesta) = :mes';
    $paramsEncuesta[':mes'] = $mes;
}
if ($anio !== 'Todos') {
    $whereEncuestaSQL .= ($whereEncuestaSQL ? ' AND ' : ' WHERE ') . 'YEAR(fecha_encuesta) = :anio';
    $paramsEncuesta[':anio'] = $anio;
}

$sqlEncuestas = "SELECT id, calificacion, fecha_encuesta FROM encuestas $whereEncuestaSQL ORDER BY fecha_encuesta DESC";
$stmt3 = $pdo->prepare($sqlEncuestas);
$stmt3->execute($paramsEncuesta);
$encuestas = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Datos para gráfico encuestas (cuentas por calificación)
$sqlGrafEncuesta = "SELECT calificacion, COUNT(*) as cantidad FROM encuestas $whereEncuestaSQL GROUP BY calificacion";
$stmt4 = $pdo->prepare($sqlGrafEncuesta);
$stmt4->execute($paramsEncuesta);
$datosGrafEncuesta = $stmt4->fetchAll(PDO::FETCH_ASSOC);

$calificaciones = [];
$cantidadesEncuestas = [];
foreach ($datosGrafEncuesta as $fila) {
    $calificaciones[] = $fila['calificacion'];
    $cantidadesEncuestas[] = (int)$fila['cantidad'];
}

header('Content-Type: application/json');
echo json_encode([
    'pqrs' => $pqrs,
    'graficoPQRS' => [
        'tipos' => $tipos,
        'cantidades' => $cantidadesPQRS,
    ],
    'encuestas' => $encuestas,
    'graficoEncuestas' => [
        'calificaciones' => $calificaciones,
        'cantidades' => $cantidadesEncuestas,
    ]
]);
exit;
?>
