<?php session_start();

if($_SESSION['rol'] == 1){
    header('Location: administrador') ;
}else{
    header('Location: controllers/index.php');
    return;
}