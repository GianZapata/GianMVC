<?php

class Pedidos {

    public function __construct(){
        $this->conexion = (new Conexion())->openConnection();
    }

    function getAllPedidos(){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT ordenes.id AS id_pedido, ordenes.id_usuario AS id_usuario, 
            usuarios.nombre AS nombre_usuario,estatus.id AS id_estatus, estatus.nombre AS nombre_estatus,
            metodos_pagos.id AS metodo_pago_id, metodos_pagos.nombre AS metodo_pago, ordenes.fecha_creacion AS fecha,
            ordenes.total AS total FROM ordenes INNER JOIN estatus ON ordenes.id_estatus = estatus.id
            INNER JOIN usuarios ON ordenes.id_usuario = usuarios.id 
            INNER JOIN metodos_pagos ON ordenes.id_metodo_pago = metodos_pagos.id
        ');
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    function setPedido($datos){        
        $statement = $this->conexion->prepare('INSERT INTO ordenes(id,id_usuario,id_estatus,fecha_creacion,direccion_envio,id_metodo_pago,subtotal,total,sub_total_tax) VALUES(NULL,:id_usuario,:id_estatus,DEFAULT,:direccion_envio,:id_metodo_pago,:subtotal,:total,:sub_total_tax)');
        $statement->execute(array(
            ':id_usuario' => $datos->idUsuario,':id_estatus' => $datos->idEstatus,
            ':direccion_envio' => $datos->direccionEnvio, ':id_metodo_pago' => $datos->idMetodoPago, 
            ':subtotal' => $datos->subTotal, ':total' => $datos->total, ':sub_total_tax' => $datos->subTotalTax
        ));
        $idOrden = $this->conexion->lastInsertId();
        foreach($datos->productos as $key => $producto){
            $statement = $this->conexion->prepare('INSERT INTO orden_productos(id,id_producto,cantidad,id_orden,id_tipo_producto,precio) VALUES(NULL,:id_producto,:cantidad,:id_orden,:id_tipo_producto,:precio)');
            $statement->execute(array(
                ':id_producto' => $producto->idProducto, ':cantidad' => $producto->cantidad, ':id_orden' => $idOrden, 
                ':id_tipo_producto' => $producto->idTipoProducto, ':precio' => $producto->precio
            ));
        }
        return $idOrden;
    }

    function borrarPedido($id){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('DELETE FROM ordenes WHERE id = :id');
        $statement->execute([':id' => $id]);
        return $id;
    }

    function getPedido($idPedido){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT * FROM ordenes WHERE id = :id');
        $statement->execute([':id' => $idPedido]);
        $resultados = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultados;        
    }

}