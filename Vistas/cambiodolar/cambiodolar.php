<?php
// Esto verifica si hay una sesion activa
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
  <title>Tasa de cambio del dólar</title>
  <link rel="stylesheet" href="vistas/cambiodolar/styles.css">
</head>
<body>

  <div class="contenedor">
    <h1>Precio del dólar</h1>
    
    <!-- Formulario para ingresar la tasa de cambio del dólar -->
    <form id="formulario-dolar" method="post" action="?respdolar=guardarPrecio">
      <div>
        <div class="radio-group">
            <label>
                <input type="radio" name="tipo_tasa" value="manual" checked> Manual
            </label>
            <label>
                <input type="radio" name="tipo_tasa" value="api">Tasa BCV
            </label>
        </div>
        <label for="precio">Por favor, ingrese la tasa del día:</label>
        <input type="text" id="precio" name="precio" placeholder="00.00bs">
        <button type="submit">INGRESAR</button>
        <br>
        <!-- Botón para cancelar y enlace para generar reporte de precios -->
        <button type="button" onclick="history.back();" class="btn-cancelar">Cancelar</button>
      </div>
      <br>
      <a href="Reportes/reporte_preciosD.php" target="_blank" class="btn-3">Generar Reporte de Precios</a>
    </form>
  </div>

  <!-- Se incluye los archivos JavaScript -->
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/validaciones.js"></script>
  <script src="js/tasa_api.js"></script>
</body>
</html>
