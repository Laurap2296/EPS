<?php
require_once 'conexion.php';

$tipo_solicitud = $_GET['tipo_solicitud'] ?? 'Todas';
$mes = $_GET['mes'] ?? 'Todos';
$anio = $_GET['anio'] ?? 'Todos';

// Filtro para PQRS
$filtro = "WHERE 1=1";
if ($tipo_solicitud != 'Todas') $filtro .= " AND tipo_solicitud = '$tipo_solicitud'";
if ($mes != 'Todos') $filtro .= " AND MONTH(fecha_solicitud) = '$mes'";
if ($anio != 'Todos') $filtro .= " AND YEAR(fecha_solicitud) = '$anio'";

// Consulta PQRS
$queryPQRS = $pdo->query("
    SELECT UPPER(tipo_solicitud) AS tipo_solicitud, COUNT(*) as cantidad 
    FROM pqrs $filtro 
    GROUP BY UPPER(tipo_solicitud)
");
$labelsPQRS = [];
$datosPQRS = [];
while ($row = $queryPQRS->fetch(PDO::FETCH_ASSOC)) {
    $labelsPQRS[] = $row['tipo_solicitud'];
    $datosPQRS[] = (int)$row['cantidad'];
}

// Consulta Encuestas
$queryEncuestas = $pdo->query("
    SELECT UPPER(satisfaccion) AS satisfaccion, COUNT(*) as cantidad 
    FROM respuesta_encuesta 
    GROUP BY UPPER(satisfaccion)
");
$labelsEncuesta = [];
$datosEncuesta = [];
while ($row = $queryEncuestas->fetch(PDO::FETCH_ASSOC)) {
    $labelsEncuesta[] = $row['satisfaccion'];
    $datosEncuesta[] = (int)$row['cantidad'];
}
?>

<canvas id="graficoPQRS" width="400" height="200"></canvas>
<canvas id="graficoEncuestas" width="400" height="200" class="mt-4"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx1 = document.getElementById('graficoPQRS').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelsPQRS) ?>,
        datasets: [{
            label: 'PQRS por tipo',
            data: <?= json_encode($datosPQRS) ?>,
            backgroundColor: ['#2196F3', '#E91E63', '#FFC107', '#4CAF50']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: true } }
    }
});

const ctx2 = document.getElementById('graficoEncuestas').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: <?= json_encode($labelsEncuesta) ?>,
        datasets: [{
            label: 'Encuestas por satisfacción',
            data: <?= json_encode($datosEncuesta) ?>,
            backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: true } }
    }
});
</script>

