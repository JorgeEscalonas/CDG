<?php
require '../fpdf/fpdf.php';
require_once '../modelo/conexion.php';

$conn = Conexion::conectar();

$query = "SELECT * FROM proveedor";
$resultado = $conn->query($query);

$proveedores = array();
if ($resultado) {
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $proveedores[] = $fila;
    }
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 5, 10);
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Image('../Vistas/header/logo.png', 10, 5, 40);
$pdf->SetY(10);

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, 'Reporte de Proveedores', 0, 1, 'C');
$pdf->Ln(2);

$ancho_pagina = $pdf->GetPageWidth();
$ancho_columna = 10 + 80; // 90mm total por columna
$gap = 5; // Espacio entre columnas
$pos_x_col1 = 12.5; // Centrado manual aproximado: (210 - (90*2 + 5)) / 2
$pos_x_col2 = $pos_x_col1 + $ancho_columna + $gap;

// Encabezados para ambas columnas
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($pos_x_col1);
$pdf->Cell(10, 6, 'ID', 1, 0, 'C');
$pdf->Cell(80, 6, 'Nombre', 1, 0, 'C');
$pdf->SetX($pos_x_col2);
$pdf->Cell(10, 6, 'ID', 1, 0, 'C');
$pdf->Cell(80, 6, 'Nombre', 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);

$col = 1; // Columna actual
$y_inicial = $pdf->GetY(); // Guardar posición inicial de la tabla
$limite_y = 280; // Límite inferior de la página (A4 es 297mm)

foreach ($proveedores as $proveedor) {
    // Si llegamos al límite de la página en la columna actual
    if ($pdf->GetY() >= $limite_y) {
        if ($col == 1) {
            $col = 2; // Pasar a la columna 2
            $pdf->SetY($y_inicial); // Volver al inicio de la tabla
        } else {
            $pdf->AddPage(); // Nueva página
            $col = 1;
            // Repetir encabezados si hay nueva página
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetX($pos_x_col1);
            $pdf->Cell(10, 6, 'ID', 1, 0, 'C');
            $pdf->Cell(80, 6, 'Nombre', 1, 0, 'C');
            $pdf->SetX($pos_x_col2);
            $pdf->Cell(10, 6, 'ID', 1, 0, 'C');
            $pdf->Cell(80, 6, 'Nombre', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 9);
            $y_inicial = $pdf->GetY();
        }
    }

    // Posicionar según la columna actual
    if ($col == 1) {
        $pdf->SetX($pos_x_col1);
        $pdf->Cell(10, 5.5, $proveedor['idProveedor'], 1, 0, 'C');
        $pdf->Cell(80, 5.5, utf8_decode($proveedor['nombreP']), 1, 1, 'C');
    } else {
        $pdf->SetX($pos_x_col2);
        $pdf->Cell(10, 5.5, $proveedor['idProveedor'], 1, 0, 'C');
        $pdf->Cell(80, 5.5, utf8_decode($proveedor['nombreP']), 1, 1, 'C');
    }
}

$pdf->Output();
?>