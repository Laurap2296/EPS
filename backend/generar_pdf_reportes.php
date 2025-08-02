<?php
// backend/generar_pdf_reportes.php

require_once 'conexion.php';
require('../librerias/fpdf/fpdf.php');

// Consulta datos para PQRS
$stmt = $pdo->prepare("SELECT tipo_solicitud AS tipo, COUNT(*) AS cantidad FROM pqrs GROUP BY tipo_solicitud");
$stmt->execute();
$pqrs_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta datos para Encuesta
$stmt2 = $pdo->prepare("SELECT satisfaccion, COUNT(*) AS cantidad FROM respuesta_encuesta GROUP BY satisfaccion");
$stmt2->execute();
$encuesta_data = $stmt2->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Reporte PQRS y Encuestas',0,1,'C');
        $this->Ln(5);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Tabla PQRS
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,"Tabla PQRS por Tipo",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,7,'Tipo',1);
$pdf->Cell(40,7,'Cantidad',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
foreach($pqrs_data as $row){
    $pdf->Cell(100,7,$row['tipo'],1);
    $pdf->Cell(40,7,$row['cantidad'],1);
    $pdf->Ln();
}

$pdf->Ln(10);

// Tabla Encuesta
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,"Tabla de Encuestas por Satisfacción",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,7,'Satisfacción',1);
$pdf->Cell(40,7,'Cantidad',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
foreach($encuesta_data as $row){
    $pdf->Cell(100,7,$row['satisfaccion'],1);
    $pdf->Cell(40,7,$row['cantidad'],1);
    $pdf->Ln();
}

$pdf->Output();
