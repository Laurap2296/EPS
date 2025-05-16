<?php
require_once '../librerias/fpdf/fpdf.php';  // ✅ Corrige la ruta si es necesario

function generarPDFPQRS($tipo_solicitud, $motivo, $descripcion, $tipo_emisor, $usuario, $archivo_nombre = '') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'KAMKUAMA IPS - Registro de PQRS', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Fecha: ' . date('Y-m-d H:i:s'), 0, 1);
    $pdf->Cell(0, 10, 'Usuario: ' . $usuario['nombre'], 0, 1);
    $pdf->Cell(0, 10, 'Tipo de solicitud: ' . $tipo_solicitud, 0, 1);
    $pdf->Cell(0, 10, 'Motivo: ' . $motivo, 0, 1);
    $pdf->MultiCell(0, 10, 'Descripcion: ' . $descripcion);
    $pdf->Ln(5);

    // Si hay archivo adjunto
    if ($archivo_nombre && file_exists('../uploads/' . $archivo_nombre)) {
        $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);
        $ext_permitidas = ['jpg', 'jpeg', 'png']; // webp NO ES SOPORTADO
        if (in_array(strtolower($extension), $ext_permitidas)) {
            $pdf->Cell(0, 10, 'Evidencia:', 0, 1);
            $pdf->Image('../uploads/' . $archivo_nombre, 10, $pdf->GetY(), 60);
        } else {
            $pdf->Cell(0, 10, 'Evidencia adjunta: ' . $archivo_nombre, 0, 1);
        }
    }

    $nombre_pdf = 'pqrs_' . time() . '.pdf';
    $ruta_pdf = '../pdf/' . $nombre_pdf;
    $pdf->Output('F', $ruta_pdf);

    return $nombre_pdf;
}
