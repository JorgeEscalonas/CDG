<?php
// Esto verifica si ha una sesion activa
$varSesion = $_SESSION['nombre']; 
if($varSesion == null || $varSesion == ''){
    header("Location: ../../Vistas/sinAcceso.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="vistas/login/images/logocorto.ico">
    <link rel="stylesheet" href="Vistas/header/style.css">
    <title>Tu Página Web</title>
</head>
<body>

<header>
    <div class="logo">
    <a href=" index.php">
            <img src="vistas/header/logo.png" alt="logo de La Casa De Los Granos">
 </a>
    </div>
    <!-- Menú de navegación -->
    <nav>
        <ul>
            <!-- Opciones del menú -->
             <li><a href="index.php" class="nav-button">Inicio</a></li>
            <li><a href="?resp=producto" class="nav-button">Productos</a></li>
            <li><a href="?respc=categoria" class="nav-button">Categorias</a></li>
            <li><a href="?resps=proveedor" class="nav-button">Proveedores</a></li>
            <li><a href="?respdolar=dolar" class="nav-button">Cambio Dólar</a></li>
            <li><a href="?cerrar_sesion=true" class="nav-button">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>

</body>
</html>
