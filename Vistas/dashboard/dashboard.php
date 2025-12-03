<?php
// Esto verifica si ha una sesion activa
$varSesion = $_SESSION['nombre']; 
if($varSesion == null || $varSesion == ''){
    header("Location: ../../../CDG/Vistas/login/login.php");
    die();
}

include_once 'vistas/header/header.php';
include_once 'Controlador/controlDolar.php';
include_once 'Controlador/control.php';
include_once 'Controlador/controlProveedor.php';
include_once 'Controlador/controlCategoria.php';

$controlDolar = new ControlDolar();
$control = new Control();
$controlProveedor = new ControlProveedor();
$controlCategoria = new ControlCategoria();

// Obtener datos para el dashboard
$productos = $control->MODEL->listar();
$categorias = $controlCategoria->MODEL->listarCategorias();
$proveedores = $controlProveedor->MODELPROV->listarProveedores();
$ultimoPrecioDolar = $controlDolar->obtenerUltimoPrecioDolar();

// Contar totales
$totalProductos = count($productos);
$totalCategorias = count($categorias);
$totalProveedores = count($proveedores);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Vistas/dashboard/styles.css">
    <link rel="icon" href="vistas/login/images/logocorto.ico">
    <title>Casa de los Granos</title>
</head>

<body>
    <div class="dashboard-container">
        <h1>Panel de Control</h1>
        <p class="welcome-message">Bienvenido, <?php echo htmlspecialchars($varSesion); ?></p>

        <!-- Tarjetas de estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon product-icon">
                    <?php echo file_get_contents(__DIR__ . '/../svg/package.svg'); ?>
                </div>
                <div class="stat-content">
                    <h3>Productos</h3>
                    <p class="stat-number"><?php echo $totalProductos; ?></p>
                    <a href="?resp=producto" class="stat-link">Ver productos</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon category-icon">
                    <?php echo file_get_contents(__DIR__ . '/../svg/tags.svg'); ?>
                </div>
                <div class="stat-content">
                    <h3>Categorías</h3>
                    <p class="stat-number"><?php echo $totalCategorias; ?></p>
                    <a href="?respc=categoria" class="stat-link">Ver categorías</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon provider-icon">
                    <?php echo file_get_contents(__DIR__ . '/../svg/truck.svg'); ?>
                </div>
                <div class="stat-content">
                    <h3>Proveedores</h3>
                    <p class="stat-number"><?php echo $totalProveedores; ?></p>
                    <a href="?resps=proveedor" class="stat-link">Ver proveedores</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon dollar-icon">
                    <?php echo file_get_contents(__DIR__ . '/../svg/dollar.svg'); ?>
                </div>
                <div class="stat-content">
                    <h3>Tipo de Cambio</h3>
                    <p class="stat-number">
                        <?php 
                        if ($ultimoPrecioDolar !== false) {
                            echo 'Bs. ' . number_format($ultimoPrecioDolar['precio'], 2, '.', ',');
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </p>
                    <a href="?respdolar=dolar" class="stat-link">Actualizar dólar</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

