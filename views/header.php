<?php $pageNameUrl = str_replace(".view.php","",basename($_SERVER['PHP_SELF']));?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gian MVC</title>   
    <link rel="preconnect" href="https://fonts.gstatic.com">    
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Oswald&family=PT+Sans&family=Raleway&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="config/css/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="config/css/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="config/css/bootstrap.min.css">
    <link rel="stylesheet" href="config/css/normalize.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="config/css/style.css?v=<?php echo time();?>">
</head>

<body>
<?php if($pageNameUrl != 'login' && $pageNameUrl != 'registro' && $pageNameUrl != 'recuperar_contra' && $pageNameUrl != 'new_contra'):?>
<header class="site-header">
    <div class="contenedor-header">
        <nav>
            <ul>
                <li><a class="logo" href="inicio">Gian' Shop</a></li>                                  
                <?php if(!isset($_SESSION['usuario'])): ?>                      
                <li><a href="login" data-toggle="tooltip" data-placement="bottom" title="Iniciar Sesión"><i class="fas fa-user"></i></a></li>
                <?php else: ?>                
                <li><a href="mi_cuenta" data-toggle="tooltip" data-placement="bottom" title="Mi cuenta">Hola <?php echo ucfirst(strtolower($_SESSION['usuario']));?></a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION['usuario']) ):?>
                    <?php if($_SESSION['rol'] == 1):?>
                        <li><a href="administrador" data-toggle="tooltip" data-placement="bottom" title="Administrador"><i class="fas fa-user-shield"></i></a></li>
                    <?php endif;?>
                    <li><a href="pedidos" data-toggle="tooltip" data-placement="bottom" title="Pedidos"><i class="fas fa-chart-bar"></i></a></li>
                <?php endif;?>
                <li class="carrito-icono"><a href="carrito" data-toggle="tooltip" data-placement="bottom" title="Carrito"><i class="fas fa-shopping-cart"></i></a></li>
                <?php if(isset($_SESSION['usuario'])):?>
                <li><a href="cerrar" data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesión"><i class="fas fa-door-closed"></i></a></li>     
                <?php endif; ?>
            </ul>
        </nav>
    </div>

</header>
<?php endif; ?>
