<?php require '../controllers/historialController.php'; ?>
<?php require 'header.php'; ?>

    <div class="container mt-5">
        <h2>Historial de cuenta</h2>        
        <?php foreach($historialCuenta as $key => $historial): ?>        

        <?php $total = 0; ?>
        <div class="container p-0">
            <div class="p-1 mb-3">
                <h4><?php echo '#' . $historial['id_orden'] . ' - ' . $historial['fecha']; ?></span>
                <a class="ver-pedido btn btn-outline-info" href="pedido?id=<?php echo $historial['id_orden']?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </a>
            </div>
            <table class="tabla tabla-historial mb-3">
                <thead>
                    <tr>
                        <th style="width: 100px;"></th>
                        <th>Producto</th>
                        <th>Cantidad</th>                    
                        <th>Precio</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                <?php $productos = $historialModel->getHistorialProductos($historial['id_orden']); ?>
                <?php foreach ($productos as $key => $producto): ?>
                <?php $total = $total + doubleval(($producto['precio'] * $producto['cantidad']));	?>
                    <tr>
                        <td class="td-imagen"><img src="config/img/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>"></td>
                        <td><?php echo $producto['nombre'];?></td>
                        <td><span></span><?php echo $producto['cantidad'];?></td>
                        <td>$<?php echo number_format($producto['precio'], 2 ,  "." , ",");?></td>
                        <td>$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2 ,  "." , ",") ;?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex flex-row mb-2">
                <h4>SubTotal: $<span><?php echo number_format ( $total, 2 ,  "." , "," ); ?></span></h4>
            </div>
        </div>
        
        <?php endforeach; ?>
    </div>
<?php require 'footer.php'; ?> 