<?php
class Conexion {
    private     $server = "mysql:host=localhost;dbname=gianmvc";
    private     $user = "root";
    private     $pass = "";
    private     $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
    protected   $conexion;
     
        public function openConnection(){
            try{
                $this->conexion = new PDO($this->server, $this->user,$this->pass,$this->options);
                return $this->conexion;
            }catch (PDOException $e){
                return false;
            }
        }

        public function closeConnection() {
            $this->conexion = null;
        }
}