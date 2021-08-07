<?php session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: ../inicio");
}else{
    switch ($_SESSION['rol']) {
        case 1:
            header("Location: ../administrador");
            break;
        case 2:
            header("Location: ../inicio");
        break;
    }
    
}

?>