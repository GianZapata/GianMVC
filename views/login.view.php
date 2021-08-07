<?php session_start(); 

if(isset($_SESSION['usuario'])){
    header('Location: inicio'); 
} 

?>
<?php require 'header.php';?>

<div class="contenedor-form bg-azul">
    <main class="main-form">
        <form id="formulario" action="POST" autocomplete="off" data-form="login">
            <label class="titulo-form">Iniciar Sesión</label>
            <div class="contenido-form">
                <label>Usuario / Correo</label>
                <div class="cont-form-input">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input id="usuario-correo" class="input-form" type="text" placeholder="Usuario / Correo electrónico" autocomplete="off">
                </div>
            </div>
            <div class="contenido-form">
                <label>Contraseña</label>
                <div class="cont-form-input">
                    <span class="input-icon"><i class="fas fa-user"></i></span>
                    <input id="password" class="input-form" type="password" placeholder="Contraseña" autocomplete="off">
                    <i class="show-button fas fa-eye"></i>
                </div>
            </div>
            <div class="cont-lost-password" style="display: flex;justify-content:right;margin:8px 0;">
                <a href="recuperar_contra" class="lost-password" style="color: #052230;text-decoration:none;">¿Has olvidado tu contraseña?</a>
            </div>
            <div class="contenedor-botones">
                <button id="send" class="boton btn-azul">Enviar</button>
            </div>
        </form>
        <div class="cont-registro" style="display: flex;flex-direction: column; align-items: center;">
            <p style="font-size: 18px;color: #fff;">¿Aun no tienes cuenta?</p>
            <a href="registro" style="color: #6dd5ed;text-decoration:none;">Registrate</a>
        </div>
    </main>
</div>




<?php require 'footer.php' ?>