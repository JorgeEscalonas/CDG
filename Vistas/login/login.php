<?php
// Se incluye el controlador de usuario
include_once '../../Controlador/controlUsuario.php';

// Valida si se están recibiendo los datos con el metodo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $_SESSION['nombre'] = $nombre;
    
    // Intenta iniciar sesión y redirigir en caso de que sea exitoso
    if (ControlUsuario::iniciarSesion($nombre, $password)) {
        header("Location: ../../index.php");
        exit();
    } else {
        $error = "Nombre de usuario o contraseña incorrectos.";
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../Vistas/login/images/logocorto.ico">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="../../Vistas/login/estiloLogin.css">
</head>

<body>
    <!-- Formulario de inicio de sesión -->
    <form action="" method="post" autocomplete="off">
        <!-- Imagen de logo y título -->
        <img src="../../Vistas/login/images/logotipo.png" alt="logo de la casa de los granos">
        <h1> Bienvenido</h1>
        <br>
        <!-- Mensaje de error -->
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <div class="input-group">
            <div class="input-container">
                <input type="text" name="nombre" placeholder="Usuario">
            </div>
            <div class="input-container">
                <input type="password" name="password" placeholder="Contraseña">
            </div>
            <input name="send" type="submit" class="btn" value="Ingresar">
        </div>
    </form>
</body>

</html>