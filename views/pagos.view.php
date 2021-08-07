<?php session_start();
if(empty($_SESSION['productos'])){
    header('Location: inicio');
}
if(empty($_SESSION['productos']) || empty($_SESSION)){
    $productos = empty($_COOKIE['productos']) ? [] : json_decode(stripslashes($_COOKIE['productos']));
}else{
    $productos = $_SESSION['productos'];
}
$total = 0;
require 'header.php';
?>

<div class="container mt-5">
    <h1>Checkout</h1>
    <div class="mt-3">
        <h2>Detalle del carrito</h2>
        <table id="tabla-carrito" class="tabla mb-2">
            <thead>
                <tr>
                    <th style="width: 100px;"></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th style="width: 50px;">Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $key => $producto): ?>
            <?php $total = $total + doubleval(($producto->precio * $producto->cantidad));	?>
                <tr data-id="<?php echo $producto->idProducto;?>">
                    <td class="td-imagen"><img src="<?php echo $producto->imagen;?>" alt="<?php echo $producto->titulo;?>"></td>
                    <td><?php echo $producto->idProducto;?></td>
                    <td><?php echo $producto->titulo;?></td>
                    <td><span></span><?php echo $producto->cantidad;?></td>
                    <td><span id="total-precio">$<?php echo number_format (($producto->precio * $producto->cantidad), 2 ,  "." , "," ); ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <h4>Subtotal: $<span><?php echo number_format ( $total, 2 ,  "." , "," ); ?></span></h4>
        </div>
        <div class="d-flex justify-content-end">
            <a class="btn btn-outline-primary mr-auto" href="inicio">Seguir comprando</a>
            <button id="comprar-carrito" class="btn btn-primary">Finalizar compra</button>
        </div>
    </div>

</div>

<?php require 'footer.php'; ?>