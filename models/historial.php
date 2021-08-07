<?php

class Historial {
    
    public function __construct(){
        $this->conexion = (new Conexion())->openConnection();
    }

    function getHistorial($idUsuario){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT ordenes.id AS id_orden,ordenes.fecha_creacion AS fecha FROM ordenes WHERE id_usuario = :id_usuario');
        $statement->execute([':id_usuario' => $idUsuario]);
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
    function getHistorialProductos ($idOrden){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT productos.nombre AS nombre,
        productos.id AS id_producto,
        productos.precio AS precio,
        productos.imagen as imagen,
        orden_productos.cantidad AS cantidad FROM orden_productos 
        INNER JOIN productos ON productos.id = orden_productos.id_producto WHERE id_orden = :id_orden');
        $statement->execute([':id_orden' => $idOrden]);
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }
}