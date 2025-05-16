<?php
session_start();
if (!isset($_SESSION['funcionario'])) {
    die("No autorizado.");
}
header('Content-Type: application/json');
// ... tu código para generar array ...
echo json_encode($resultado);
exit;


require_once '../librerias/fpdf/fpdf.php';

class PDF extends FPDF {
    // Header
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Reporte PQRS y Encuestas - Kamkuama IPS',0,1,'C');
        $this->Ln(5);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Datos enviados por POST: imágenes base64 de gráficos
$imgPQRS = $_POST['imgPQRS'] ?? '';
$imgEncuestas = $_POST['imgEncuestas'] ?? '';

// Insertar gráfico PQRS
if ($imgPQRS) {
    // Quitar prefijo base64
    $imgPQRSdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgPQRS));
    $rutaImgPQRS = tempnam(sys_get_temp_dir(), 'pqrs') . '.png';
    file_put_contents($rutaImgPQRS, $imgPQRSdata);
    $pdf->Cell(0,10,"Gráfico PQRS por Tipo:",0,1);
    $pdf->Image($rutaImgPQRS, null, null, 180);
    unlink($rutaImgPQRS);
    $pdf->Ln(10);
}

// Insertar gráfico Encuestas
if ($imgEncuestas) {
    $imgEncuestasData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgEncuestas));
    $rutaImgEncuestas = tempnam(sys_get_temp_dir(), 'enc') . '.png';
    file_put_contents($rutaImgEncuestas, $imgEncuestasData);
    $pdf->Cell(0,10,"Gráfico Encuestas:",0,1);
    $pdf->Image($rutaImgEncuestas, null, null, 180);
    unlink($rutaImgEncuestas);
    $pdf->Ln(10);
}

// Consultar datos para tablas con filtros recibidos del formulario (si quieres usar filtros)
// Para simplicidad, mostramos sólo las tablas sin filtro extra

require_once 'conexion.php';

// PQRS tabla
$pdf->Cell(0,10,"Tabla PQRS:",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,7,'ID',1);
$pdf->Cell(40,7,'Tipo Solicitud',1);
$pdf->Cell(65,7,'Motivo',1);
$pdf->Cell(35,7,'Fecha',1);
$pdf->Cell(25,7,'Estado',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);
$stmt = $pdo->query("SELECT id, tipo_solicitud, motivo, fecha_solicitud, estado FROM pqrs ORDER BY fecha_solicitud DESC LIMIT 50");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(15,6,$row['id'],1);
    $pdf->Cell(40,6,$row['tipo_solicitud'],1);
    $pdf->Cell(65,6,substr($row['motivo'],0,40),1);
    $pdf->Cell(35,6,$row['fecha_solicitud'],1);
    $pdf->Cell(25,6,$row['estado'],1);
    $pdf->Ln();
}

$pdf->Ln(10);

// Encuestas tabla
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,10,"Tabla Encuestas:",0,1);
$pdf->Cell(30,7,'ID Encuesta',1);
$pdf->Cell(40,7,'Calificación',1);
$pdf->Cell(50,7,'Fecha Encuesta',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);
$stmt2 = $pdo->query("SELECT id, calificacion, fecha_encuesta FROM encuestas ORDER BY fecha_encuesta DESC LIMIT 50");
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(30,6,$row['id'],1);
    $pdf->Cell(40,6,$row['calificacion'],1);
    $pdf->Cell(50,6,$row['fecha_encuesta'],1);
    $pdf->Ln();
}

$pdf->Output('I', 'Reporte_PQRS_Encuestas.pdf');
exit;
?>
