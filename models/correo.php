<?php
include '../config/mailer/src/PHPMailer.php';
include '../config/mailer/src/SMTP.php';
include '../config/mailer/src/Exception.php';


class Correo {
    private $conexion;

    public function __construct(){
        $this->conexion = new Conexion;
    }

    public function enviarCorreo($correo,$key){
        $body = '
        <p>Querido Usuario,</p>
        <p>Haga clic en el siguiente enlace para restablecer su contraseña.</p>
        <p>-------------------------------------------------------------</p>
        <div>
            <a href="http://'.$_SERVER['HTTP_HOST'].'/GianMVC/nueva_contra?key='.$key.'&email='.$correo.'&action=reset">http://'.$_SERVER['HTTP_HOST'].'/GianMVC/nueva_contra?key='.$key.'&email='.$correo.'&action=reset</a>
        </div>
        <p>-------------------------------------------------------------</p>
        <p>Asegúrese de copiar el enlace completo en su navegador. El enlace caducará después de 1 día por motivos de seguridad.</p>
        <p>Si no solicitó este correo electrónico con la contraseña olvidada, no hay acción
        es necesario, su contraseña no se restablecerá. Sin embargo, es posible que desee iniciar sesión en
        su cuenta y cambie su contraseña de seguridad, ya que alguien puede haberlo adivinado</p>
        <p>Gracias...</p>
        ';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = "smtp.office365.com";
        $mail->Port       = "587";
        $mail->SMTPAuth   = "true";
        $mail->SMTPSecure = "STARTTLS";
        $mail->Username   = "14559@virtual.utsc.edu.mx";        
        $mail->Password   = "Elgianfn123";
        $mail->CharSet = 'UTF-8';
        $mail->setfrom("14559@virtual.utsc.edu.mx", 'Gian');
        $mail->addAddress($correo);
        
        $mail->isHTML(true);
        $mail->Subject = 'Restablecer contraseña';        
        $mail->Body = $body;

        if ($mail->send()) {
            return true;            
        }else{                   
            return false;   
        }
    }

    public function setCorreoDB($correo,$key,$expDate){
        try {
            $conexion = $this->conexion->openConnection();   
            $statement = $conexion->prepare('INSERT INTO password_reset_temp (`email`, `key`, `expDate`) VALUES(:email,:key,:expDate)');
            $statement->execute(array(':email' => $correo,':key' => $key , ':expDate' => $expDate));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function comprobarPassTemp($email,$key,$curDate){
        try {
            $conexion = $this->conexion->openConnection();   
            $statement = $conexion->prepare('SELECT * FROM password_reset_temp WHERE `key` = :key AND`email` = :email ');
            $statement->execute(array(':email' => $email, ':key' => $key));
            $rows = $statement->rowCount();
            if($rows == 1){
                $resultado = $statement->fetch();
                $expDate = $resultado['expDate'];
                if($expDate >= $curDate){
                    return true;
                }
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }                
    }

    public function setPassTemp($email,$password){
        try {
            $conexion = $this->conexion->openConnection();   
            $statement = $conexion->prepare('UPDATE `usuarios` SET `pass` = :pass WHERE `correo` = :correo');
            $statement->execute(array(':correo' => $email, ':pass' => $password));  
            $statement = $conexion->prepare('DELETE FROM `password_reset_temp` WHERE email = :email');
            $statement->execute(array(':email' => $email));
            return true;
        } catch (Exception $e) {
            return false;
        }    
    }

    public function enviarCorreoPedido($idOrden,$correo){
        $body = "
            <div>
                <p>Gracias por comprar con nosotros</p>                
                <h2>Tu pedido #${idOrden} esta siendo procesado, gracias</h2>                
            </div>        
        ";
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = "smtp.office365.com";
        $mail->Port       = "587";
        $mail->SMTPAuth   = "true";
        $mail->SMTPSecure = "STARTTLS";
        $mail->Username   = "14559@virtual.utsc.edu.mx";        
        $mail->Password   = "Elgianfn123";
        $mail->CharSet = 'UTF-8';
        $mail->setfrom("14559@virtual.utsc.edu.mx", 'Gian Shop');
        $mail->addAddress($correo);
        
        $mail->isHTML(true);
        $mail->Subject = '!Hemos recibido tu pedido¡';        
        $mail->Body = $body;

        if ($mail->send()) {
            return true;            
        }else{                   
            return false;   
        }
    }

}