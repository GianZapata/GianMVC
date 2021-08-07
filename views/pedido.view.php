<?php require '../controllers/validacionPedidoController.php'; ?> 
<?php require '../controllers/getPedidosController.php'; ?>
<?php require 'header.php';?>


<div class="container mt-5">
<a href="pedidos" class="btn btn-outline-primary mb-3"><i class="fas fa-undo"></i> Regresar </a>
    <h2>Información del Pedido</h2>
    <div class="form-group">
        <label for="" class="font-weight-bold">Nombre</label>
        <input type="text" class="form-control" disabled value="<?php echo $usuarioInfo['nombre'];?>">
    </div>
    <div class="form-group">
        <label for="" class="font-weight-bold">Correo</label>
        <input type="text" class="form-control" disabled value="<?php echo $usuarioInfo['correo'];?>">
    </div>
    <div class="form-group">
        <label for="" class="font-weight-bold">Fecha del pedido</label>
        <input type="text" class="form-control" disabled value="<?php echo date_format($fecha,"d/m/Y"); ?>">
    </div>
    <h5 class="border-top border-bottom p-2">Productos comprados</h5>
    <table class="tabla tabla-historial  mt-3 mb-3 p-0">
        <thead>
            <tr>
                <th style="width: 100px;"></th>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>                    
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $key => $producto): ?>
        <?php $total = $total + doubleval(($producto['precio'] * $producto['cantidad']));	?>
            <tr>
                <td class="td-imagen"><img src="config/img/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>"></td>
                <td><?php echo $producto['id_producto'];?></td>
                <td><?php echo $producto['nombre'];?></td>
                <td>$<?php echo number_format($producto['precio'], 2 ,  "." , ",");?></td>
                <td><span></span><?php echo $producto['cantidad'];?></td>
                <td>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2 ,  "." , ",") ;?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end mb-2 align-items-center">
        <button class="btn btn-danger mr-auto" onclick="window.print()">Imprimir <i class="fas fa-print"></i></button>
        <h4 class="m-0">Total: $<span><?php echo number_format ( $total, 2 ,  "." , "," ); ?></span></h4>
    </div>
</div>


<?php require 'footer.php';?>




    


