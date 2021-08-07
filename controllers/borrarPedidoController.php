<?php session_start();
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/pedidos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    $productoStd = new stdClass();
    $pedidoModel = new Pedidos();
    $id = $_POST['data-id'];
    $resultados = $pedidoModel->borrarPedido($id);
    echo json_encode($resultados);
    exit();
}