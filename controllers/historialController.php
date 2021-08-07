<?php session_start();
if(!isset($_SESSION['usuario'])){ 
    header('Location: inicio'); 
    return;
} 
$idUsuario = $_SESSION['id_usuario'];
require '../models/database.php';
require '../models/historial.php';
$historialModel = new Historial();
$historialCuenta = $historialModel->getHistorial($idUsuario);