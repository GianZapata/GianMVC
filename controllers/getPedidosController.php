<?php 
require '../models/database.php';
require '../models/pedidos.php';
require '../models/productos.php';
require '../models/historial.php';
require '../models/persona.php';

$idPedido = $_GET['id'];
$historialModel = new Historial();
$usuarioModel = new Persona();
$pedidosModel = new Pedidos();
$pedidoInfo = $pedidosModel->getPedido($idPedido);
$usuarioBool = $pedidoInfo['id_usuario'] === $_SESSION['id_usuario'] ? true : false;
$adminBool = $_SESSION['rol'] == 1 ? true : false;

if($adminBool == false){
    if($usuarioBool == false){        
        header('Location: inicio');        
    }
}

$productos = $historialModel->getHistorialProductos($idPedido); 
$usuarioInfo = $usuarioModel->getUsuario($pedidoInfo['id_usuario']);
$total = 0;
$fecha = date_create($pedidoInfo['fecha_creacion']);

