<?php
require '../fpdf/fpdf.php';
require_once '../modelo/conexion.php';

$conn = Conexion::conectar();

$query = "SELECT * FROM categoria";
$resultado = $conn->query($query);

$categorias = array();
if ($resultado) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $categorias[] = $fila;
    }
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 5, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Image('../Vistas/header/logo.png', 10, 5, 40); 
$pdf->SetY(10);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, 'Reporte de Categorias', 0, 1, 'C');
$pdf->Ln(2);

$ancho_pagina = $pdf->GetPageWidth();
$ancho_celda = 15 + 90; 
$posicion_x = ($ancho_pagina - $ancho_celda) / 2;

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($posicion_x); 
$pdf->Cell(15, 6, 'ID', 1, 0, 'C');
$pdf->Cell(90, 6, 'Nombre', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
foreach($categorias as $categoria) {
    $pdf->SetX($posicion_x); 
    $pdf->Cell(15, 6, $categoria['idCategoria'], 1, 0, 'C');
    $pdf->Cell(90, 6, utf8_decode($categoria['nombreC']), 1, 1, 'C');
}

function Footer() {
    global $pdf;
    if ($pdf->PageNo() > 1) {
        $pdf->SetY(-15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Página ' . $pdf->PageNo(), 0, 0, 'C');
    }
}

$pdf->Output();
?>
