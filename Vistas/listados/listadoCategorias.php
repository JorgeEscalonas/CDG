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
    <title>Lista de Categorias</title>
</head>

<body>
    <div class="cont-table">
        <h2>Listado de Categorias</h2>
        <!-- Tabla de categorías -->
        <table id="categoriasTable">
            <thead>
                <tr>
                    <th class="id">id</th>
                    <th>Categoria</th>
                    <th class="accion-col" orderable="false">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $c):?> 
                <!-- Datos de las categorías -->
                <tr>
                    <td class="id"><?php echo $c->idCategoria;?></td>
                    <td><?php echo $c->nombreC;?></td>
                    <td class="accion-col">
                        <a href="?respc=eliminarC&id=<?php echo $c->idCategoria; ?>" class="btn-1" onclick="return confirmarEliminar()">Eliminar</a>
                        <a href="?respc=nuevoC&id=<?php echo $c->idCategoria; ?>" class="btn-2">Editar</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <br>
        <!-- Botones para registrar nuevas categorías y generar reportes -->
        <div class="button-container">
            <a href="?respc=categoriaC" class="btn-3">Registrar Categoria</a>
            <a href="Reportes/reporte_categorias.php" target="_blank" class="btn-3">Generar Reporte de Categorias</a>
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
