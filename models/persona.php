<?php 

class Persona {
    private $conexion;

    public function __construct(){
        $this->conexion = new Conexion;
    }

    public function login ($datos){
        $conexion = $this->conexion->openConnection();  
        $password = hash('sha512',  $datos->pass);   
        $statement = $conexion->prepare("SELECT * FROM usuarios WHERE (usuario = :usuario OR correo = :correo) AND pass = :pass LIMIT 1");  
        $statement->execute(array(':usuario' => $datos->usuario, ':pass' =>  $password , ':correo' => $datos->usuario));
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        if($resultado != false){
            return $resultado;
        }else{
            return false;
        }
    }
    public function register ($datos){
        $conexion = $this->conexion->openConnection();     
        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE (usuario = :usuario OR correo = :correo) LIMIT 1');
        $statement->execute(array(':usuario' => $datos->usuario, ':correo' => $datos->correo));
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);

        if($resultado !== false){
            array_push($datos->errores, 'El nombre de usuario ya existe');
            return $datos;
        }
        
        $password = hash('sha512', $datos->pass);
        $password2 = hash('sha512', $datos->pass2);

        if ($password != $password2) {
            array_push($datos->errores, 'Las contraseñas no son iguales');
            return $datos;
        }

        if(empty($datos->errores)){
            $statement = $conexion->prepare('INSERT INTO usuarios (id,nombre,correo,usuario,pass) VALUES (null,:nombre,:correo,:usuario,:pass)');
            $statement->execute(array(':nombre' => $datos->usuario, ':correo' => $datos->correo, ':usuario' => $datos->usuario, ':pass' => $password ));
            $id = $conexion->lastInsertId();
            $statement = $conexion->prepare('SELECT * FROM usuarios WHERE id = :id');
            $statement->execute(array(':id' => $id));
            $resultado = $statement->fetch(PDO::FETCH_ASSOC);  
            return $resultado;                     
        }
        return $datos;        
    }

    public function comprobarUsuario($email) {
        $conexion = $this->conexion->openConnection();   
        $statement = $conexion->prepare('SELECT correo, pass FROM usuarios WHERE correo = :correo LIMIT 1');
        $statement->execute(array(':correo' => $email));
        $resultado = $statement->fetch();
        return $resultado;
    }

    public function tablaUsuarios (){
        $conexion = $this->conexion->openConnection();   
        $statement = $conexion->prepare('SELECT * FROM usuarios');
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function getUsuario($idUsuario){
        $conexion = $this->conexion->openConnection();   
        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE id = :id LIMIT 1');
        $statement->execute(array(':id' => $idUsuario));
        $resultado = $statement->fetch();
        return $resultado;
    }
}