<?php
session_start();
require '../backend/conexion.php';
require '../template/encabezado.php';

// Variables filtro con valores por defecto o recibidos por GET
$filtro_ano = $_GET['ano'] ?? date('Y');
$filtro_mes = $_GET['mes'] ?? '';
$filtro_tipo = $_GET['tipo'] ?? '';

// Preparar condiciones de filtro para la consulta
$where = "WHERE 1=1 ";
$params = [];

if ($filtro_ano) {
    $where .= " AND YEAR(fecha_solicitud) = :ano ";
    $params[':ano'] = $filtro_ano;
}

if ($filtro_mes) {
    $where .= " AND MONTH(fecha_solicitud) = :mes ";
    $params[':mes'] = $filtro_mes;
}

if ($filtro_tipo) {
    $where .= " AND tipo_solicitud = :tipo ";
    $params[':tipo'] = $filtro_tipo;
}

// Consulta PQRS filtrada
$stmt = $pdo->prepare("SELECT tipo_solicitud AS tipo, COUNT(*) AS cantidad FROM pqrs $where GROUP BY tipo_solicitud");
$stmt->execute($params);
$pqrs_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta encuesta (no tiene fecha o tipo, si quieres agregarlo también se puede modificar)
$stmt2 = $pdo->prepare("SELECT satisfaccion, COUNT(*) AS cantidad FROM respuesta_encuesta GROUP BY satisfaccion");
$stmt2->execute();
$encuesta_data = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// Preparar datos para gráficos JS
$tipos = [];
$cantidades_pqrs = [];
foreach ($pqrs_data as $row) {
    $tipos[] = $row['tipo'];
    $cantidades_pqrs[] = (int)$row['cantidad'];
}

$satisfacciones = [];
$cantidades_encuesta = [];
foreach ($encuesta_data as $row) {
    $satisfacciones[] = $row['satisfaccion'];
    $cantidades_encuesta[] = (int)$row['cantidad'];
}

// Obtener lista de tipos para el filtro (únicos en BD)
$stmtTipos = $pdo->query("SELECT DISTINCT tipo_solicitud FROM pqrs");
$lista_tipos = $stmtTipos->fetchAll(PDO::FETCH_COLUMN);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reportes PQRS y Encuestas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <style>
    canvas {
      max-width: 100%;
      height: 300px !important;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <h2 class="mb-4">Reportes PQRS y Encuestas</h2>

    <!-- Formulario de filtros -->
    <form method="GET" class="row g-3 mb-4 align-items-end">
      <div class="col-md-3">
        <label for="ano" class="form-label">Año</label>
        <select name="ano" id="ano" class="form-select">
          <?php 
          $anio_actual = date('Y');
          for ($i = $anio_actual; $i >= $anio_actual - 10; $i--): ?>
            <option value="<?= $i ?>" <?= $i == $filtro_ano ? 'selected' : '' ?>><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label for="mes" class="form-label">Mes</label>
        <select name="mes" id="mes" class="form-select">
          <option value="" <?= $filtro_mes == '' ? 'selected' : '' ?>>Todos</option>
          <?php 
          for ($m=1; $m<=12; $m++):
            $nombre_mes = date('F', mktime(0,0,0,$m,1));
          ?>
            <option value="<?= $m ?>" <?= $m == $filtro_mes ? 'selected' : '' ?>><?= ucfirst($nombre_mes) ?></option>
          <?php endfor; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label for="tipo" class="form-label">Tipo de Solicitud</label>
        <select name="tipo" id="tipo" class="form-select">
          <option value="" <?= $filtro_tipo == '' ? 'selected' : '' ?>>Todos</option>
          <?php foreach ($lista_tipos as $tipo): ?>
            <option value="<?= htmlspecialchars($tipo) ?>" <?= $tipo == $filtro_tipo ? 'selected' : '' ?>><?= htmlspecialchars($tipo) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </form>

    <div class="mb-3">
      <!-- Pasar filtros a la generación PDF -->
      <a href="../backend/generar_pdf_reportes.php?ano=<?= urlencode($filtro_ano) ?>&mes=<?= urlencode($filtro_mes) ?>&tipo=<?= urlencode($filtro_tipo) ?>" class="btn btn-danger me-2" target="_blank">
        <i class="bi bi-file-pdf"></i> Generar PDF
      </a>
      <a href="../backend/exportar_excel.php?ano=<?= urlencode($filtro_ano) ?>&mes=<?= urlencode($filtro_mes) ?>&tipo=<?= urlencode($filtro_tipo) ?>" class="btn btn-success" target="_blank">
        <i class="bi bi-file-earmark-excel"></i> Exportar Excel
      </a>
    </div>

    <!-- Tabla PQRS -->
    <h4>Tabla PQRS por Tipo</h4>
    <table class="table table-striped table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pqrs_data as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['tipo']) ?></td>
            <td><?= htmlspecialchars($row['cantidad']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Tabla Encuesta -->
    <h4>Tabla de Encuestas por Satisfacción</h4>
    <table class="table table-striped table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Satisfacción</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($encuesta_data as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['satisfaccion']) ?></td>
            <td><?= htmlspecialchars($row['cantidad']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Gráficos -->
    <div class="row mt-4">
      <div class="col-md-6 mb-4">
        <h5>Gráfico PQRS por Tipo</h5>
        <canvas id="graficoPQRS"></canvas>
      </div>
      <div class="col-md-6 mb-4">
        <h5>Gráfico Encuesta de Satisfacción</h5>
        <canvas id="graficoEncuesta"></canvas>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const tipos = <?= json_encode($tipos) ?>;
    const cantidadesPQRS = <?= json_encode($cantidades_pqrs) ?>;
    const satisfacciones = <?= json_encode($satisfacciones) ?>;
    const cantidadesEncuesta = <?= json_encode($cantidades_encuesta) ?>;

    const ctxPQRS = document.getElementById('graficoPQRS').getContext('2d');
    new Chart(ctxPQRS, {
      type: 'bar',
      data: {
        labels: tipos,
        datasets: [{
          label: 'Cantidad',
          data: cantidadesPQRS,
          backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });

    const ctxEncuesta = document.getElementById('graficoEncuesta').getContext('2d');
    new Chart(ctxEncuesta, {
      type: 'pie',
      data: {
        labels: satisfacciones,
        datasets: [{
          label: 'Satisfacción',
          data: cantidadesEncuesta,
          backgroundColor: [
            'rgba(75, 192, 192, 0.7)', 
            'rgba(153, 102, 255, 0.7)', 
            'rgba(255, 99, 132, 0.7)'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  </script>

<?php include '../template/pie.php'; ?>
</body>
</html>
