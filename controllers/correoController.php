<?php 
header('Content-type:application/json; charset=utf8');
require '../models/database.php';
require '../models/correo.php';
require '../models/persona.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dataForm'])) {
    $datos = new stdClass();   
    $datos->tipo = $_POST['dataForm'];
    $datos->successMessage = ""; 
    $datos->errores = [];
    $datos->url = "";
    

    if($_POST['dataForm'] == 'recuperar_contra'){
        $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
        $usuario = (new Persona())->comprobarUsuario($correo);
        if($usuario !== false){        
            $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
            $expDate = date("Y-m-d H:i:s",$expFormat);
            $key = md5(2418*2+(int)$correo);
            $addKey = substr(md5(uniqid(rand(),1)),3,10);
            $key = $key . $addKey;
            $correoModel = new Correo();
            if($correoModel->setCorreoDB($correo,$key,$expDate)){
                if($correoModel->enviarCorreo($correo,$key)){
                    $datos->successMessage = 'Correo enviado correctamente, por favor cheque su correo';              
                }else{
                    array_push($datos->erorres,'Ha habido un problema al enviar el correo electrónico, inténtelo de nuevo');             
                }
            }else{
                array_push($datos->errores,'Hubo un error');
            }    
        }else{
            array_push($datos->errores,'Ningún usuario está registrado con este correo electrónico');
        }
    }else if($_POST['dataForm'] == 'nueva_contra'){
        $email = filter_var(filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        $password = hash('sha512', $_POST['pass']);
        $password2 = hash('sha512', $_POST['pass2']);

        if ($password != $password2) {
            array_push($datos->errores, 'La contraseña no coincide, ambas deben ser iguales');
        }

        if (empty($datos->errores)) {
            $correoModel = new Correo();
            if ($correoModel->setPassTemp($email,$password)) {
                $datos->successMessage = "¡Felicidades! Su contraseña se ha actualizado correctamente";   
            }else{
                array_push($datos->errores,'Hubo un error');
            }
        }

    }else{
        array_push($datos->errores,'Hubo un error, recargue la pagina por favor!');
    }

    echo json_encode($datos);    
    return;
}