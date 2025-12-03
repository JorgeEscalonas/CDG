<?php
session_start();

// Esto lo que hace es cerrar la sesion en caso de que sea solicitado
if(isset($_GET['cerrar_sesion'])) {
    session_destroy();
    header("Location: vistas/login/login.php"); 
}

// Se incluyen los archivos necesarioas
include_once 'Controlador/control.php';
include_once 'Controlador/controlUsuario.php';
include_once 'Controlador/controlProveedor.php';
include_once 'Controlador/controlDolar.php';
include_once 'Controlador/controlCategoria.php';
include_once 'Modelo/conexion.php';

// Instancia los objetos de controladores
$controlProducto = new Control();
$controlProveedor = new ControlProveedor();
$controlDolar = new ControlDolar();
$controlCategoria = new ControlCategoria();
$controlUsuario = new ControlUsuario();

// Con esto se procesan las solicitudes relacionadas con productos
if(isset($_REQUEST['resp'])){
    $actionProducto = $_REQUEST['resp'];
    if(method_exists($controlProducto, $actionProducto)){
        call_user_func(array($controlProducto, $actionProducto));
    }
}

// Con esto se procesan las solicitudes relacionadas con proveedores
if(isset($_REQUEST['resps'])){
    $actionProveedor = $_REQUEST['resps'];
    if(method_exists($controlProveedor, $actionProveedor)){
        call_user_func(array($controlProveedor, $actionProveedor));
    }
}

// Con esto se procesan las solicitudes relacionadas con el tipo de cambio del dólar
if(isset($_REQUEST['respdolar'])){
    $actionDolar = $_REQUEST['respdolar'];
    if(method_exists($controlDolar, $actionDolar)){
        call_user_func(array($controlDolar, $actionDolar));
    }
}

// Con esto se procesan las solicitudes relacionadas con categorías
if(isset($_REQUEST['respc'])){
    $actionCategoria = $_REQUEST['respc'];
    if(method_exists($controlCategoria, $actionCategoria)){
        call_user_func(array($controlCategoria, $actionCategoria));
    }
}

// Muestra el dashboard si no se recibe ninguna solicitud específica
if (!isset($_REQUEST['resp']) && !isset($_REQUEST['resps']) && !isset($_REQUEST['respdolar']) && !isset($_REQUEST['respc'])) {
    $controlProducto->dashboard();
}
