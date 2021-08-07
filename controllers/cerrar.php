<?php session_start();

session_destroy();
$_SESSION = array();
setcookie('productos', "[]", time() + 60 * 60 * 24 * 30, '/');        
header('Location: inicio');
