<?php
require_once  '../librerias/fpdf/fpdf.php';

function generarPDFRespuesta($pqrs_id, $respuesta, $funcionario_nombre) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10, "Respuesta PQRS #$pqrs_id", 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0,10, "Respuesta del funcionario $funcionario_nombre:\n\n$respuesta");
    
    $nombreArchivo = "respuesta_pqrs_{$pqrs_id}_" . time() . ".pdf";
    $rutaArchivo = __DIR__ . '/../pdf/' . $nombreArchivo;
    $pdf->Output('F', $rutaArchivo);

    return $nombreArchivo;
}
