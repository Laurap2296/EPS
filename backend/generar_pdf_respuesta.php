<?php
require '../librerias/fpdf/fpdf.php';
require '../backend/conexion.php';

function generarPDFRespuesta($pqrs_id, $respuesta, $funcionario_nombre) {
    // Obtener datos de la PQRS
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM pqrs WHERE id = :id");
    $stmt->execute([':id' => $pqrs_id]);
    $pqrs = $stmt->fetch(PDO::FETCH_ASSOC);

    $nombre_archivo = "respuesta_pqrs_$pqrs_id.pdf";
    $ruta_archivo = "../pdf/$nombre_archivo";

    $pdf = new FPDF();
    $pdf->AddPage();

    // Encabezado Kamkuama
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Kamkuama IPS - Respuesta PQRS', 0, 1, 'C');
    $pdf->Ln(5);

    // Datos de PQRS
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Tipo de Solicitud: ' . $pqrs['tipo_solicitud'], 0, 1);
    $pdf->Cell(0, 10, 'Motivo: ' . $pqrs['motivo'], 0, 1);
    $pdf->Cell(0, 10, 'Fecha de Solicitud: ' . $pqrs['fecha_solicitud'], 0, 1);
    $pdf->MultiCell(0, 10, 'Descripcion: ' . $pqrs['descripcion'], 0, 1);
    $pdf->Ln(5);

    // Respuesta
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Respuesta del Funcionario:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $respuesta, 0, 1);
    $pdf->Ln(5);

    // Pie de página
    $pdf->SetY(-30);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Funcionario: ' . $funcionario_nombre, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Kamkuama IPS - Todos los derechos reservados', 0, 0, 'C');

    $pdf->Output('F', $ruta_archivo);
    return $nombre_archivo;
}
