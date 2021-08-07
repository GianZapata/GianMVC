<?php session_start(); 

if(isset($_SESSION['usuario'])){
    header('Location: inicio'); 
} 

?>
<?php require 'header.php';?>

<div class="contenedor-form bg-azul">
    <main class="main-form">
        <form id="formulario" action="POST" autocomplete="off" data-form="recuperar_contra">
            <label class="titulo-form">Recuperar Contraseña</label>            
            <div class="contenido-form">
                <label>Correo Electrónico</label>
                <div class="cont-form-input">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input id="correo" class="input-form" type="email" placeholder="Correo electrónico" autocomplete="off">
                </div>
            </div>
            <div class="contenedor-botones">
                <button id="send" class="boton btn-azul">Enviar</button>
            </div>
        </form>
        <div class="cont-registro" style="display: flex;flex-direction: column; align-items: center;">            
            <a href="inicio" style="color: #6dd5ed;text-decoration:none;">Volver a inicio</a>
        </div>
    </main>
</div>

<?php require 'footer.php' ?>