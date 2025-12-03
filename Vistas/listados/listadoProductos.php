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

$controlDolar = new ControlDolar();
$control = new Control();

// Se obtiene la categoría seleccionada o se asigna nulo si no hay ninguna
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

$productos = $control->MODEL->listar($categoria);
$categorias = $control->MODEL->listarCategorias();
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
    <title>Lista de Productos</title>
</head>

<body>
    <div class="cont-table">
        <h2>Listado de Productos</h2>

        <!-- Formulario para filtrar por categoría -->
        <form action="" method="GET">
            <input type="hidden" name="resp" value="producto">
            <label for="categoria">Filtrar por categoría:</label>
            <select name="categoria" id="categoria">
                <option value="">Todas las categorías</option>
                <!-- Opciones de categorías -->
                <?php foreach ($categorias as $categoriaOption): ?>
                    <?php
                    // Verifica si la categoría actual está seleccionada
                    $selected = ($categoria == $categoriaOption->idCategoria) ? 'selected' : '';
                    ?>
                    <option value="<?php echo $categoriaOption->idCategoria; ?>" <?php echo $selected; ?>>
                        <?php echo $categoriaOption->nombreC; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Filtrar" class="btn-3">
        </form>

        <!-- Tabla de productos -->
        <table id="productosTable">
            <thead>
                <tr>
                    <th class="id">ID</th>
                    <th>Nombre</th>
                    <th>Proveedor</th>
                    <th>Categoría</th>
                    <th>Costo</th>
                    <th>PVP</th>
                    <th>Bs.</th>
                    <th class="accion-col" orderable="false">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td class="id"><?php echo $producto->idProducto; ?></td>
                        <td><?php echo $producto->nombre; ?></td>
                        <td><?php echo $producto->nombreP; ?></td>
                        <td><?php echo $producto->nombreC; ?></td>
                        <td>$<?php echo $producto->costo; ?></td>
                        <td>$<?php echo $producto->pvp; ?></td>
                        <td>
                        <?php
                        // Se calcula el precio en bolívares utilizando el último precio del dólar
                        $ultimoPrecioDolar = $controlDolar->obtenerUltimoPrecioDolar();
                        if ($ultimoPrecioDolar !== false) {
                            $precioEnBolivares = $producto->pvp * $ultimoPrecioDolar['precio'];
                            $precioFormateado = number_format($precioEnBolivares, 2, '.', '');
                            echo 'Bs. ' . $precioFormateado;
                        } else {
                            echo "No se pudo obtener el precio del dólar.";
                        }
                        ?>
                        </td>
                        <!-- Acciones disponibles para cada producto -->
                        <td class="accion-col">
                            <a href="?resp=eliminar&id=<?php echo $producto->idProducto; ?>" class="btn-1" onclick="return confirmarEliminar()">Eliminar</a>
                            <a href="?resp=nuevo&id=<?php echo $producto->idProducto; ?>" class="btn-2">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Botones para registrar nuevos productos y generar reportes -->
        <div class="button-container">
            <a href="?resp=nuevo" class="btn-3">Registrar Producto</a>
            <a href="Reportes/reporte_productos.php?categoria=<?php echo $categoria; ?>" target="_blank" class="btn-3">Generar Reporte de Productos</a>
        </div>
    </div>

    <!-- Se iincluyen los archivos JavaScript -->
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/validaciones.js"></script>
    <script src="js/detalles.js"></script>
</body>

</html>
