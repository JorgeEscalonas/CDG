<?php
// Esto verifica si ha una sesion activa
$varSesion = $_SESSION['nombre']; 
if($varSesion == null || $varSesion == ''){
    header("Location: ../../Vistas/sinAcceso.php");
    die();
}

// Detectar la página actual para resaltar el menú activo
$pagina_actual = 'inicio'; // Por defecto es inicio

if(isset($_GET['resp']) && $_GET['resp'] == 'producto'){
    $pagina_actual = 'productos';
} elseif(isset($_GET['respc']) && $_GET['respc'] == 'categoria'){
    $pagina_actual = 'categorias';
} elseif(isset($_GET['resps']) && $_GET['resps'] == 'proveedor'){
    $pagina_actual = 'proveedores';
} elseif(isset($_GET['respdolar']) && $_GET['respdolar'] == 'dolar'){
    $pagina_actual = 'dolar';
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
        <a href="index.php">
            <img src="vistas/header/logo.png" alt="logo de La Casa De Los Granos">
        </a>
    </div>
    <!-- Botón hamburguesa para móviles -->
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <!-- Menú de navegación -->
    <nav id="navMenu">
        <ul>
            <!-- Opciones del menú -->
            <li><a href="index.php" class="nav-button <?php echo ($pagina_actual == 'inicio') ? 'active' : ''; ?>">Inicio</a></li>
            <li><a href="?resp=producto" class="nav-button <?php echo ($pagina_actual == 'productos') ? 'active' : ''; ?>">Productos</a></li>
            <li><a href="?respc=categoria" class="nav-button <?php echo ($pagina_actual == 'categorias') ? 'active' : ''; ?>">Categorias</a></li>
            <li><a href="?resps=proveedor" class="nav-button <?php echo ($pagina_actual == 'proveedores') ? 'active' : ''; ?>">Proveedores</a></li>
            <li><a href="?respdolar=dolar" class="nav-button <?php echo ($pagina_actual == 'dolar') ? 'active' : ''; ?>">Cambio Dólar</a></li>
            <li><a href="?cerrar_sesion=true" class="nav-button">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>

<script>
// Toggle del menú móvil
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
        
        // Cerrar el menú al hacer clic en un enlace (solo en móviles)
        const navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    navMenu.classList.remove('active');
                    menuToggle.classList.remove('active');
                }
            });
        });
    }
});
</script>

</body>
</html>
