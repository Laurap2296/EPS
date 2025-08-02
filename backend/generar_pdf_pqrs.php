<?php
require_once '../librerias/fpdf/fpdf.php';

function generarPDFPQRS($tipo_solicitud, $motivo, $descripcion, $tipo_emisor, $usuario, $archivo_nombre) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10, utf8_decode('PQRS Individual'),0,1,'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10, utf8_decode('Tipo de Solicitud: ') . utf8_decode($tipo_solicitud), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Motivo: ') . utf8_decode($motivo), 0, 1);
    $pdf->MultiCell(0,10, utf8_decode('Descripción: ') . utf8_decode($descripcion), 0, 1);
    $pdf->Cell(0,10, utf8_decode('Emisor: ') . utf8_decode($tipo_emisor . ' - ' . ($usuario['nombre'] ?? 'Desconocido')), 0, 1);
    $pdf->Ln(10);

    if ($archivo_nombre && file_exists("../uploads/$archivo_nombre")) {
        $pdf->Cell(0,10, utf8_decode('Evidencia Adjunta:'), 0, 1);
        $pdf->Image("../uploads/$archivo_nombre", null, null, 100);
    }

    $nombre_pdf = 'pqrs_' . time() . '.pdf';
    $ruta_pdf = '../pdf/' . $nombre_pdf;
    $pdf->Output('F', $ruta_pdf);

    return $nombre_pdf;
}
?>
