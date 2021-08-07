<?php session_start();
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/pedidos.php';
require '../models/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $variable = false;
    $datos = new stdClass();
    $datos->url = "";

    if(isset($_SESSION['id_usuario']) && isset($_SESSION['usuario'])){
        $idUsuario = $_SESSION['id_usuario'];
        $productos = json_decode(stripslashes($_POST['productos']));
        $idEstatus = 5; //En espera
        $direccionEnvio = "Puerta Mitras"; //Pendiente por agregar en el Front End
        $idMetodoPago = $_POST['metodoPago']; 
        $subTotal = $_POST['subTotal'];
        $total = $_POST['total'];
        $subTotalTax = $_POST['subTotalTax']; 
               
        $datos->idUsuario = $idUsuario;
        $datos->idEstatus = $idEstatus;
        $datos->direccionEnvio = $direccionEnvio;
        $datos->idMetodoPago = $idMetodoPago;
        $datos->subTotal = $subTotal;
        $datos->total = $total;
        $datos->subTotalTax = $subTotalTax;
        $datos->productos = $productos;
            
        $pedido = new Pedidos();
        $idOrden = $pedido->setPedido($datos);
        $correo = new Correo();
        $correoResults = $correo->enviarCorreoPedido($idOrden,$_SESSION['correo_usuario']);
        
        $datos->url = "carrito";
    }else{
        $datos->url = "login";
    }


    echo json_encode($datos);
    exit();
}








