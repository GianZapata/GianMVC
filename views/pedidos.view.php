<?php session_start();
require '../models/database.php';
require '../models/pedidos.php';
require 'header.php';

if(!isset($_SESSION['usuario'])){
    header('Location: login');
    return;
}else{
}
$pedidos = new Pedidos();
$pedidos = $pedidos->getAllPedidos();
?>
<div id="contenedor-administrador" class="container mt-5">    
    <div>
        <h2>Pedidos</h2>
        <!-- <button id="add-pedido" class="btn btn-primary">Nuevo</button> -->
        <table id="tabla-pedidos" class="tabla">
            <thead>
                <tr>
                    <th>N.Pedido</th>
                    <th>Cliente</th>
                    <th>Estatus</th>
                    <th>Metodo Pago</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <!-- <th style="width: 150px;"></th> -->
                    <th style="width: 150px;">Ver Pedido</th>
                    <?php if($_SESSION['rol'] == 1 ):?>
                    <th style="width: 150px;"></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $key => $pedido) : ?>
                <tr data-id="<?php echo $pedido['id_pedido'];?>">
                    <td><?php echo $pedido['id_pedido']?></td>
                    <td><?php echo $pedido['nombre_usuario']?></td>
                    <td><?php echo $pedido['nombre_estatus']?></td>
                    <td><?php echo $pedido['metodo_pago']?></td>
                    <td><?php echo '$'. number_format ( $pedido['total'], 2 ,  "." , "," );?></td>
                    <td><?php echo $pedido['fecha']?></td>
                    <!-- <td class="td-editar">
                         <button class="editar-pedido btn btn-info mr-2">Editar 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        </button> 
                    </td> -->                     
                    <td>                
                        <a class="ver-pedido btn btn-outline-info" href="<?php //echo $_SESSION['rol'] == 1 ? 'pedido' : 'ver_pedido';?>pedido?id=<?php echo $pedido['id_pedido']?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
</svg></a>
                    </td>
                    <?php if($_SESSION['rol'] == 1 ):?>
                    <td class="td-borrar">
                        
                            <button class="borrar-pedido btn btn-danger">Eliminar 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg> 
                            </button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>

<?php require 'footer.php' ?>