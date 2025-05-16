<?php
header('Content-Type: application/json');
require_once 'conexion.php';

try {
    // Conexión PDO correcta con $pdo
    $sql = "SELECT * FROM pqrs";
    $stmt = $pdo->query($sql);
    $pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Simulación de datos de gráficos
    $graficoPQRS = [
        'tipos' => ['Petición', 'Queja', 'Reclamo'],
        'cantidades' => [5, 3, 7]
    ];

    $graficoEncuestas = [
        'calificaciones' => ['Excelente', 'Bueno', 'Regular'],
        'cantidades' => [10, 4, 2]
    ];

    echo json_encode([
        'pqrs' => $pqrs,
        'graficoPQRS' => $graficoPQRS,
        'graficoEncuestas' => $graficoEncuestas,
        'encuestas' => [] // puedes llenar esto igual
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
