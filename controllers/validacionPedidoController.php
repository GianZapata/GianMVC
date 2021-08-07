<?php session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['id'])){
    header('Location: inicio');
    exit();
}


