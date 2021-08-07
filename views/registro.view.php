<?php session_start();
if(isset($_SESSION['usuario'])){
    header('Location: inicio');
}

?>
<?php require 'header.php';?>

    <div class="contenedor-form bg-azul">
        <main class="main-form">
            <form id="formulario" action="POST" autocomplete="off" data-form="register">
                <label class="titulo-form">Registrarse</label>
                <div class="contenido-form">
                    <label>Usuario</label>
                    <div class="cont-form-input">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input id="usuario" class="input-form" type="text" placeholder="Usuario" autocomplete="off">
                    </div>
                </div>
                <div class="contenido-form">
                    <label>Correo Electrónico</label>
                    <div class="cont-form-input">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input id="correo" class="input-form" type="text" placeholder="Correo electrónico" autocomplete="off">
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
                <div class="contenido-form">
                    <label>Confirmar Contraseña</label>
                    <div class="cont-form-input">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input id="password2" class="input-form" type="password" placeholder="Confirmar contraseña" autocomplete="off">
                        <i class="show-button fas fa-eye"></i>
                    </div>
                </div>
                <div class="contenedor-botones">
                    <button id="send" class="boton btn-azul">Enviar</button>
                </div>
            </form>
            <div class="cont-registro" style="display: flex;flex-direction: column; align-items: center;">
                <p style="font-size: 18px;color:#fff;">¿Ya tienes una cuenta?</p>  
                <a href="login" style="color: #6dd5ed;">Iniciar Sesión</a>
            </div>  
        </main>
    </div>

<?php require 'footer.php' ?>