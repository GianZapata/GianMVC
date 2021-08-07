<?php session_start();
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/persona.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $person = new Persona();
    $result = $person->tablaUsuarios();
    echo json_encode($result);
    return;
}