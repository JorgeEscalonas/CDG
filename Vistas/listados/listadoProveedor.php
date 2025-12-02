<?php
// Esto verifica si ha una sesion activa
$varSesion = $_SESSION['nombre']; 
if($varSesion == null || $varSesion == ''){
    header("Location: ../../Vistas/sinAcceso.php");
    die();
}

include_once 'vistas/header/header.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Vistas/listados/style.css">
    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <title>Lista de Proveedores</title>
</head>

<body>
    <div class="cont-table">
        <h2>Listado de Proveedores</h2>
        <table id="proveedoresTable">
            <thead>
                <tr>
                    <th class="id">id</th>
                    <th>Nombre</th>
                    <th class="accion-col" orderable="false">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($proveedores)) : ?>
                    <?php foreach ($proveedores as $d):?> <!-- Con esto se muestran todos los proveedores registrados -->
                        <tr>
                            <td class="id"><?php echo $d->idProveedor;?></td>
                            <td><?php echo $d->nombreP;?></td>
                            <!-- Acciones disponibles para cada proveedor -->
                            <td class="accion-col">
                                <a href="?resps=eliminarProveedor&id=<?php echo $d->idProveedor; ?>" class="btn-1" onclick="return confirmarEliminar()">Eliminar</a>
                                <a href="?resps=actualizarProveedor&id=<?php echo $d->idProveedor; ?>" class="btn-2">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <!-- Se muestra este mensaje en el caso en que no haya proveedores disponibles -->
                    <tr>
                        <td colspan="3">No hay proveedores disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Botones para registrar y generar reportes de proveedores -->
        <br>
        <div class="button-container">
            <a href="?resps=registrarProveedor" class="btn-3">Registrar Proveedor</a>
            <a href="Reportes/reporte_proveedor.php" target="_blank" class="btn-3">Generar Reporte de Proveedores</a>
        </div>
    </div>

    <!-- Se incluyen los archivos JavaScript -->
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/validaciones.js"></script>
    <script src="js/detalles.js"></script>
</body>

</html>
