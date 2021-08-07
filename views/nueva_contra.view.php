<?php session_start(); 
require '../models/database.php';
require '../models/correo.php';

if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && $_GET["action"] == "reset"){
    $correoModel = new Correo();
    $resultado = $correoModel->comprobarPassTemp($_GET["email"],$_GET["key"],date("Y-m-d H:i:s"));     
    if($resultado === true){
        require 'header.php'; ?>
        <div class="contenedor-form bg-azul">
            <main class="main-form">
                <form id="formulario" action="POST" autocomplete="off" data-form="nueva_contra">
                    <label class="titulo-form">Nueva Contraseña</label>            
                    <div class="contenido-form">
                        <label>Nueva Contraseña</label>
                        <div class="cont-form-input">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input id="password" class="input-form" type="password" placeholder="Contraseña" autocomplete="off">
                        </div>
                    </div>
                    <div class="contenido-form">
                        <label>Confirmar Contraseña</label>
                        <div class="cont-form-input">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input id="password2" class="input-form" type="password" placeholder="Confirmar Contraseña" autocomplete="off">
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
        <?php require 'footer.php';
    }else{
         header('Location: inicio');
    }
} else{
    header('Location: inicio');
}


