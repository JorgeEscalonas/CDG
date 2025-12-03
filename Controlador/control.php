<?php
include_once 'Modelo/claseProducto.php';
include_once 'Modelo/claseCategoria.php';

class Control {
    public $MODEL;

    public function __construct() {
        $this->MODEL = new Producto();
    }

    public function index()
    {
		include_once 'vistas/login/login.php';        
    }

    public function producto() {
        $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;
        
        if ($categoria === null) {
           
            $productos = $this->MODEL->listar();
        } else {
           
            $productos = $this->MODEL->listar($categoria);
        }
        
        include_once 'Vistas/listados/listadoProductos.php';
    }

    public function nuevo() {
        $prod = new Producto();
        if(isset($_REQUEST['id'])) {
            $prod = $this->MODEL->cargarID($_REQUEST['id']);
        }
        include_once 'Vistas/agregar/agregar.php';

		
    }

    public function guardar() {
        $prod = new Producto();
        $prod->idProducto = $_POST['id-producto'];
        $prod->nombre = $_POST['nombre-producto'];
        $prod->costo = $_POST['costo-producto'];
        $prod->idProveedor = $_POST['proveedor-producto'];
        $prod->idCategoria = $_POST['categoria-producto'];
    
        $prod->idProducto > 0 ? $this->MODEL->actualizarDatos($prod) : $this->MODEL->registrar($prod);
        
        $this->retrocederDosPaginas();
    }
    
    public function retrocederDosPaginas() {
        echo "<script>window.history.go(-2);</script>";
        exit;
    }
    
    public function eliminar() {
        $this->MODEL->eliminar($_REQUEST['id']);
        include_once 'Vistas/listados/listadoProductos.php';
    }

    public function dashboard() {
        include_once 'Vistas/dashboard/dashboard.php';
    }

	
}
