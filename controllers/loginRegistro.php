<?php session_start();
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/persona.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dataForm'])) {
    $datos = new stdClass();   
    $datos->tipo = $_POST['dataForm'];
    switch ($_POST['dataForm']) {
        case 'login':
            $user = $_POST['usuario'];
            $pass = $_POST['pass'];         
            $datos->usuario = $user;
            $datos->pass = $pass;
            $datos->errores = [];            
            $person = new Persona();
            $result = $person->login($datos);
            
            if($result != false){
                $rol = $result['roles'];
                $_SESSION['usuario'] = $user;                
                $_SESSION['rol'] = $rol;   
                $_SESSION['id_usuario'] = $result['id'];
                $_SESSION['correo_usuario'] = $result['correo'];
                $_SESSION['productos'] = [];
                $datos->url = $rol !== 1 ? 'administrador' : 'inicio';
                $datos->successMessage = "¡Conexión exitosa!";  
            }else{
                array_push($datos->errores, 'Usuario y/o password incorrecta');
            }

        break;

        case 'register':
            $user = filter_var(strtolower($_POST["usuario"]), FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
            $pass = $_POST["pass"];
            $pass2 = $_POST["pass2"];
            $datos->usuario = $user;
            $datos->correo = $email;
            $datos->pass = $pass;
            $datos->pass2 = $pass;
    
            $datos->errores = [];
            if (empty($user) || empty($email) || empty($pass) || empty($pass2)) {
                array_push($datos->errores, 'Por favor rellena todos los datos correctamente');  
            }else{
                $person = new Persona();
                $result = $person->register($datos);
            }
    
            if($result != false){
                $rol = $result['roles'];
                $_SESSION['usuario'] = $user;
                $_SESSION['rol'] = $rol;
                $_SESSION['id_usuario'] = $result['id'];
                $_SESSION['correo_usuario'] = $result['correo'];
                $_SESSION['productos'] = [];
                $datos->url = $rol !== 1 ? 'administrador' : 'inicio';
                $datos->successMessage = "¡Registro exitoso!";
            }
        break;

        default:
        break;
    }
    echo json_encode($datos);
    exit();
}
