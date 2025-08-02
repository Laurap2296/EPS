<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    header('Location: ../login.php');
    exit;
}

include '../backend/conexion.php';
include '../template/encabezado.php';

// Configuración de fechas
$fecha_actual = date('Y-m-d');

// Plazos en días hábiles para cada tipo de PQRS
$plazo_peticion_queja_reclamo = 15; // días hábiles para peticiones, quejas y reclamos
$plazo_sugerencia = 10; // días hábiles para sugerencias

// Función para calcular días hábiles entre dos fechas
function calcular_dias_habiles($fecha_inicio, $fecha_fin) {
    $dias_habiles = 0;
    $inicio = strtotime($fecha_inicio);
    $fin = strtotime($fecha_fin);
    while ($inicio <= $fin) {
        $dia_semana = date('N', $inicio);
        if ($dia_semana < 6) { // lunes a viernes
            $dias_habiles++;
        }
        $inicio = strtotime("+1 day", $inicio);
    }
    return $dias_habiles;
}

try {
    // Consulta para obtener PQRS pendientes
    $query = "SELECT * FROM pqrs WHERE estado = 'Pendiente'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $pqrs_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>Notificaciones de PQRS Pendientes</h2>
    <table class="table table-bordered">
        <thead style="background-color: #2e7d32; color: white;">
            <tr>
                <th>ID PQRS</th>
                <th>Fecha Solicitud</th>
                <th>Tipo Solicitud</th>
                <th>Fecha Estimada de Respuesta</th>
                <th>Días Restantes</th>
                <th>Estado</th>
                <th>Alerta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($pqrs_list as $pqrs) {
                $fecha_solicitud = $pqrs['fecha_solicitud'];
                $tipo_solicitud = $pqrs['tipo_solicitud'];

                // Definir plazo según tipo de solicitud
                $plazo = ($tipo_solicitud === 'Sugerencia') ? $plazo_sugerencia : $plazo_peticion_queja_reclamo;

                // Calcular fecha estimada de respuesta sumando días hábiles
                $fecha_vencimiento = date('Y-m-d', strtotime("$fecha_solicitud +$plazo weekdays"));

                // Calcular días hábiles restantes
                $dias_restantes = calcular_dias_habiles($fecha_actual, $fecha_vencimiento);

                // Definir color de alerta
                if ($dias_restantes <= 1) {
                    $color = 'red'; // Vencida
                    $titulo_alerta = 'Vencida';
                } elseif ($dias_restantes <=2) {
                    $color = 'gold'; // Por vencer
                    $titulo_alerta = 'Por vencer';
                } else {
                    $color = 'green'; // Dentro del plazo
                    $titulo_alerta = 'Dentro del plazo';
                }

                // Estilo de fila (opcional, para visibilidad)
                // $fila_style = ($color === 'red') ? 'background-color: #f8d7da;' : ''; 
                // Pero ya usamos ícono para alerta, así que dejamos fondo blanco

                echo "<tr>";
                echo "<td>" . htmlspecialchars($pqrs['id']) . "</td>";
                echo "<td>" . htmlspecialchars($fecha_solicitud) . "</td>";
                echo "<td>" . htmlspecialchars($tipo_solicitud) . "</td>";
                echo "<td>" . htmlspecialchars($fecha_vencimiento) . "</td>";
                echo "<td>" . htmlspecialchars($dias_restantes) . "</td>";
                echo "<td>" . htmlspecialchars($pqrs['estado']) . "</td>";
                
                // Columna alerta con ícono
                echo "<td style='text-align:center;'>";
                echo "<i class='bi bi-circle-fill' style='color: $color; font-size: 1.5rem;' title='$titulo_alerta'></i>";
                echo "</td>";

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../template/pie.php'; ?>
