<?php
require '../fpdf/fpdf.php';
require_once '../modelo/conexion.php';
require_once '../modelo/claseProducto.php';
require_once '../Controlador/controlDolar.php'; 

$conn = Conexion::conectar();
$productoModel = new Producto($conn);
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
$productos = $productoModel->listar($categoria); 

/*$precioEnBolivares = $producto->pvp * $ultimoPrecioDolar['precio'];
$precioFormateado = number_format($precioEnBolivares, 2, '.', '');
$precioFormateado;*/

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 5, 10); // Reducir margen superior
$pdf->SetAutoPageBreak(true, 10); // Margen inferior de 10mm
$pdf->AddPage();

// Logo más pequeño y pegado al tope
$pdf->Image('../Vistas/header/logo.png', 10, 5, 40); 
$pdf->SetY(10); // Posición inicial después del logo

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,8, 'Reporte de Productos',0,1,'C');
$pdf->Ln(2); // Pequeño espacio antes de la tabla

// Encabezados con menos altura
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,6,'ID',1,0,'C');
$pdf->Cell(40,6,'Nombre',1,0,'C');
$pdf->Cell(40,6,'Proveedor',1,0,'C');
$pdf->Cell(30,6,utf8_decode('Categoría'),1,0,'C');
$pdf->Cell(20,6,'Costo',1,0,'C');
$pdf->Cell(20,6,'PVP',1,0,'C');
$pdf->Cell(30,6,'Bs.',1,1,'C');

$pdf->SetFont('Arial','',5.5); // Fuente ligeramente más pequeña
foreach($productos as $producto) {
    // Reducción de la altura de cada celda de 6.5 a 4.5
    $pdf->Cell(10,4.5,$producto->idProducto,1,0,'C');
    $pdf->Cell(40,4.5,utf8_decode($producto->nombre),1,0,'C');
    $pdf->Cell(40,4.5,utf8_decode($producto->nombreP),1,0,'C');
    $pdf->Cell(30,4.5,utf8_decode($producto->nombreC),1,0,'C');
    $pdf->Cell(20,4.5,'$'.$producto->costo,1,0,'C');
    $pdf->Cell(20,4.5,'$'.$producto->pvp,1,0,'C');

    $controlDolar = new ControlDolar(); 
    $ultimoPrecioDolar = $controlDolar->obtenerUltimoPrecioDolar();
    if ($ultimoPrecioDolar !== false) {
        $precioEnBolivares = $producto->pvp * $ultimoPrecioDolar['precio'];
        $precioFormateado = number_format($precioEnBolivares, 2, '.', '');
        $pdf->Cell(30,4.5,'Bs.S'.$precioFormateado,1,1,'C');
    } else {
        $pdf->Cell(30,4.5,'N/A',1,1,'C');
    }
}
$pdf->Output();
?>
