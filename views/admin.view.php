<?php session_start(); 
require '../models/database.php';
require '../models/productos.php';
require '../models/pedidos.php';

if(isset($_SESSION['rol'])){
    if(intval($_SESSION['rol']) !== 1){
        header("Location: inicio");
        return;
    }
}else{
    header('Location: inicio');
    return;
}

$productos = new Productos();
$productos = $productos->leerProductos();
require 'header.php';
?>
<div id="contenedor-administrador" class="container mt-5">

    <div>
        <h2>Listado de productos</h2>
        <button id="add-producto" class="btn btn-primary mb-3">Nuevo</button>
        <table id="tabla-productos" class="tabla">    
            <thead>
                <tr>
                    <th style="width: 100px;"></th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Marca</th>
                    <th style="width: 150px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </th>
                    <th style="width: 150px;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </th>
                </tr>
            </thead>
            <tbody>  
                <?php foreach ($productos as $key => $producto) : ?>
                <tr data-id="<?php echo $producto['id'];?>">
                
                    <td class="td-imagen"><img src="config/img/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>"></td>
                    <td class="td-nombre"><?php echo $producto['nombre'];?></td>
                    <td class="td-precio">$<?php echo number_format ($producto['precio'], 2 ,  "." , "," );?></td>
                    <td class="td-marca"><?php echo $producto['marca'];?></td>
                    <td class="td-editar">
                        <button class="editar-producto btn btn-info mr-2">Editar 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        </button>
                    </td>
                    <td class="td-borrar">
                        <button class="borrar-producto btn btn-danger">Eliminar 
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> 
                        </button>
                    </td>
                </tr>              
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</div>

<?php require 'footer.php' ?>
