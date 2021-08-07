<?php session_start(); 
if(empty($_SESSION['productos']) || empty($_SESSION)){
    $productos = empty($_COOKIE['productos']) ? [] : json_decode(stripslashes($_COOKIE['productos']));
}else{
    $productos = $_SESSION['productos'];
}

$total = 0;
require 'header.php';
?>

<div class="container mt-5" >
    <h2 style="text-align: center;">Carrito</h2>
    <table id="tabla-carrito" class="tabla">
        <thead>
            <tr>
                <th style="width: 100px;"></th>
                <th>ID</th>
                <th>Nombre</th>
                <th style="width: 50px;">Cantidad</th>
                <th>Precio</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $key => $producto): ?>
        <?php $total = $total + doubleval(($producto->precio * $producto->cantidad));	?>
            <tr data-id="<?php echo $producto->idProducto;?>">
                <td class="td-imagen"><img src="<?php echo $producto->imagen;?>" alt="<?php echo $producto->titulo;?>"></td>
                <td><?php echo $producto->idProducto;?></td>
                <td><?php echo $producto->titulo;?></td>
                <td><input  class="form-control" type="number" value="<?php echo $producto->cantidad;?>"></td>
                <td>$<?php echo number_format (($producto->precio * $producto->cantidad), 2 ,  "." , "," ); ;?></td>
                
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
    <div class="d-flex flex-row mb-2">
        <a class="btn btn-outline-primary mr-2" href="inicio">Seguir comprando</a>
        <a href="#" id="vaciar-carrito" class="btn btn-outline-dark">Vaciar Carrito</a>
        <h4 class="total-carrito" style="margin-left:auto;color:#333;">Total: $<span id="total-precio"><?php echo number_format ( $total, 2 ,  "." , "," ); ?></span></h4>
    </div>
    <div class="d-flex flex-row-reverse">
        <button id="realizar-pago" class="btn btn-success">Realizar pago</button>
    </div>
        
    
</div>


<?php require 'footer.php';?>