<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reportes PQRS y Encuestas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-4">
    <?php include '../template/encabezado.php'; ?>

<h3>Reportes PQRS y Encuestas</h3>

<div class="mb-3 row">
    <label for="tipo_solicitud" class="col-sm-2 col-form-label">Tipo de Solicitud</label>
    <div class="col-sm-3">
        <select id="tipo_solicitud" class="form-select">
            <option value="Todas">Todas</option>
            <option value="Petición">Petición</option>
            <option value="Queja">Queja</option>
            <option value="Reclamo">Reclamo</option>
            <option value="Sugerencia">Sugerencia</option>
        </select>
    </div>
    <label for="mes" class="col-sm-1 col-form-label">Mes</label>
    <div class="col-sm-2">
        <select id="mes" class="form-select">
            <option value="Todos">Todos</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
    </div>
    <label for="anio" class="col-sm-1 col-form-label">Año</label>
    <div class="col-sm-2">
        <select id="anio" class="form-select">
            <option value="Todos">Todos</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <button id="mostrarReporte" class="btn btn-primary">Mostrar Reporte</button>
</div>

<hr/>

<h4>Gráfico PQRS por Tipo</h4>
<canvas id="graficoPQRS" height="100"></canvas>

<hr/>

<h4>Tabla PQRS</h4>
<table id="tablaPQRS" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo Solicitud</th>
            <th>Motivo</th>
            <th>Fecha Solicitud</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<hr/>

<h4>Gráfico Encuestas</h4>
<canvas id="graficoEncuestas" height="100"></canvas>

<hr/>

<h4>Tabla Encuestas</h4>
<table id="tablaEncuestas" class="table table-striped">
    <thead>
        <tr>
            <th>ID Encuesta</th>
            <th>Calificación</th>
            <th>Fecha Encuesta</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
$(document).ready(function() {
    let chartPQRS, chartEncuestas;

    function cargarReporte() {
        let tipo = $('#tipo_solicitud').val();
        let mes = $('#mes').val();
        let anio = $('#anio').val();

        $.ajax({
            url: '../backend/get_reportes.php',
            method: 'POST',
            data: { tipo_solicitud: tipo, mes: mes, anio: anio },
            dataType: 'json',
            success: function(data) {
                // Cargar tabla PQRS
                let tbodyPQRS = $('#tablaPQRS tbody');
                tbodyPQRS.empty();
                if(data.pqrs && data.pqrs.length > 0){
                    data.pqrs.forEach(p => {
                        tbodyPQRS.append(`<tr>
                            <td>${p.id}</td>
                            <td>${p.tipo_solicitud}</td>
                            <td>${p.motivo}</td>
                            <td>${p.fecha_solicitud}</td>
                            <td>${p.estado}</td>
                        </tr>`);
                    });
                } else {
                    tbodyPQRS.append('<tr><td colspan="5" class="text-center">No hay datos</td></tr>');
                }

                // Graficar PQRS
                let ctxPQRS = document.getElementById('graficoPQRS').getContext('2d');
                if(chartPQRS) chartPQRS.destroy();
                chartPQRS = new Chart(ctxPQRS, {
                    type: 'bar',
                    data: {
                        labels: data.graficoPQRS.tipos || [],
                        datasets: [{
                            label: 'Cantidad',
                            data: data.graficoPQRS.cantidades || [],
                            backgroundColor: 'rgba(54, 162, 235, 0.6)'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });

                // Cargar tabla Encuestas
                let tbodyEnc = $('#tablaEncuestas tbody');
                tbodyEnc.empty();
                if(data.encuestas && data.encuestas.length > 0){
                    data.encuestas.forEach(e => {
                        tbodyEnc.append(`<tr>
                            <td>${e.id}</td>
                            <td>${e.calificacion}</td>
                            <td>${e.fecha_encuesta}</td>
                        </tr>`);
                    });
                } else {
                    tbodyEnc.append('<tr><td colspan="3" class="text-center">No hay datos</td></tr>');
                }

                // Graficar Encuestas
                let ctxEnc = document.getElementById('graficoEncuestas').getContext('2d');
                if(chartEncuestas) chartEncuestas.destroy();
                chartEncuestas = new Chart(ctxEnc, {
                    type: 'pie',
                    data: {
                        labels: data.graficoEncuestas.calificaciones || [],
                        datasets: [{
                            label: 'Cantidad',
                            data: data.graficoEncuestas.cantidades || [],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });
            },
            error: function(xhr, status, error) {
                alert("Error al cargar los datos: " + error);
            }
        });
    }

    $('#mostrarReporte').click(function(){
        cargarReporte();
    });

    // Carga inicial
    cargarReporte();
});
</script>

</body>
</html>
