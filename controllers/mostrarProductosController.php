<?php 
require '../models/database.php';
require '../models/productos.php';
$productos = new Productos();
$productos = $productos->leerProductos();