<?php session_start(); ?>
<?php require '../controllers/mostrarProductosController.php'; ?>
<?php require 'header.php'; ?> 
<?php 
?>
<div class="container mt-5 mb-5">
    <h2 style="text-align:center;">Todos los productos</h2>
    <div id="lista-productos" class="contenedor-productos">
        <?php foreach($productos as $key => $producto ):?>
        <div class="producto" data-id="<?php echo $producto['id'];?>">
            <img class="imagen-producto" src="config/img/<?php echo $producto['imagen'];?>" alt="<?php echo $producto['nombre'];?>">
            <div class="info-producto"  >
                <h4><?php echo $producto['nombre'];?></h4>
                <p class="marca"><?php echo $producto['marca'];?></p>
                <img src="config/img/estrellas.png">
                <p class="precio" data-precio="<?php echo $producto['precio'];?>">$<?php echo number_format ($producto['precio'], 2 ,  "." , "," ); ?></p>
                <div style="text-align:center;">
                    <a href="#" class="btn btn-primary comprar-ahora">Comprar ahora</a>
                    <a href="#" class="btn btn-primary agregar-carrito">Agregar Al Carrito</a>
                </div>
            </div>
        </div>     
        <?php endforeach; ?>
    </div>
</div>

<?php require 'footer.php' ?>