<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'funcionario') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

include('conexion.php');

$plazo_peticion_queja_reclamo = 15;
$plazo_sugerencia = 10;

function sumar_dias_habiles($fecha, $dias) {
    $sumados = 0;
    $fecha_actual = strtotime($fecha);
    if ($fecha_actual === false) {
        return null;
    }
    while ($sumados < $dias) {
        $fecha_actual = strtotime('+1 day', $fecha_actual);
        $dia_semana = date('N', $fecha_actual);
        if ($dia_semana < 6) {
            $sumados++;
        }
    }
    return date('Y-m-d', $fecha_actual);
}

function calcular_dias_habiles($fecha_inicio, $fecha_fin) {
    $dias_habiles = 0;
    $inicio = strtotime($fecha_inicio);
    $fin = strtotime($fecha_fin);

    if ($inicio === false || $fin === false) {
        return 0;
    }

    while ($inicio <= $fin) {
        $dia_semana = date('N', $inicio);
        if ($dia_semana < 6) {
            $dias_habiles++;
        }
        $inicio = strtotime('+1 day', $inicio);
    }
    return $dias_habiles;
}

try {
    $fecha_actual = date('Y-m-d');
    $query = "SELECT * FROM pqrs WHERE estado = 'Pendiente'";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $pqrs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $notificaciones = [];

    foreach ($pqrs as $p) {
        $plazo = ($p['tipo_solicitud'] === 'Sugerencia') ? $plazo_sugerencia : $plazo_peticion_queja_reclamo;
        $fecha_venc = sumar_dias_habiles($p['fecha_solicitud'], $plazo);
        if (!$fecha_venc) {
            $fecha_venc = $p['fecha_solicitud'];
        }
        $dias_restantes = calcular_dias_habiles($fecha_actual, $fecha_venc);

        $color = 'green';
        if ($dias_restantes <= 0) {
            $color = 'red';
        } elseif ($dias_restantes <= 3) {
            $color = 'yellow';
        }

        $notificaciones[] = [
            'id' => $p['id'],
            'tipo_solicitud' => $p['tipo_solicitud'],
            'fecha_solicitud' => $p['fecha_solicitud'],
            'fecha_vencimiento' => $fecha_venc,
            'dias_restantes' => $dias_restantes,
            'color' => $color
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($notificaciones);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en el servidor']);
}
