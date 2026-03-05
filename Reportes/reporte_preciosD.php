<?php
require '../fpdf/fpdf.php';
require_once '../modelo/conexion.php';
require_once '../modelo/claseDolar.php';

$dolar = new Dolar();

$precios = $dolar->obtenerTodosLosPrecios();

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 5, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Image('../Vistas/header/logo.png', 10, 5, 40);
$pdf->SetY(10);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, utf8_decode('Reporte de Precios del Dólar'), 0, 1, 'C');
$pdf->Ln(2);

$ancho_pagina = $pdf->GetPageWidth();
$ancho_celda = 60 + 80; 
$posicion_x = ($ancho_pagina - $ancho_celda) / 2;

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($posicion_x);
$pdf->Cell(60, 6, 'Precio (USD)', 1, 0, 'C');
$pdf->Cell(80, 6, utf8_decode('Fecha de Actualización'), 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
foreach ($precios as $precio) {
    $pdf->SetX($posicion_x); 
    $pdf->Cell(60, 6, $precio['precio'], 1, 0, 'C');
    $pdf->Cell(80, 6, $precio['fecha_actualizacion'], 1, 1, 'C');
}

$pdf->Output();
?>
