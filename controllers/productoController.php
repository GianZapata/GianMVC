<?php session_start();
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/productos.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['data-action'];
    $productoStd = new stdClass();
    $productoModel = new Productos();
    $resultados;
    switch ($action) {
        case 'agregar': 
            $nombre = $_POST['data-nombre'];
            $precio = $_POST['data-precio'];
            $files = $_FILES['files'];
            $productoStd->nombre = $nombre;
            $productoStd->precio = $precio;
            $productoStd->visible = 1;
            $productoStd->disponible = 100;
            $productoStd->imagen = $files;
            $productoStd->categoria = 1;
            $productoStd->marca = 1;
            $resultados = $productoModel->agregarProducto($productoStd);
        break;

        case 'editar':
            $id = $_POST['data-id'];
            $nombre = $_POST['data-nombre'];
            $precio = $_POST['data-precio'];
            $files = $_FILES['files'];
            $productoStd->id = $id;
            $productoStd->imagen = $files;
            $productoStd->nombre = $nombre;
            $productoStd->precio = $precio;
            $resultados = $productoModel->editarProducto($productoStd);
        break;

        case 'borrar':
            $id = $_POST['data-id'];
            $productoStd->id = $id;
            $resultados = $productoModel->borrarProducto($productoStd);
        break;

        case 'getProducto':
            $id = $_POST['id'];
            $resultados = $productoModel->getProducto($id);
        break;

        default:            
        break;
    }
    
    echo json_encode($resultados);

    return;
}