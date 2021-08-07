<?php 
class Productos extends Conexion{

    public function __construct(){
        $this->conexion = Conexion::openConnection();
    }

    public function agregarProducto($producto){
        $fecha = date("Y-m-d h:i:s");
        $nombreImagen = $this->setImagen($producto->imagen);

        $statement = $this->conexion->prepare('INSERT INTO productos(id, nombre, precio, fecha_creacion, visible, disponible, imagen, categoria, marca) VALUES(null, :nombre, :precio, :fecha_creacion, :visible, :disponible, :imagen, :categoria, :marca)');
        $statement->execute([
            ':nombre' => $producto->nombre,':precio' => $producto->precio,':fecha_creacion' => $fecha, 
            ':visible' => $producto->visible,':disponible' => $producto->disponible,':imagen' => $nombreImagen, 
            ':categoria' => $producto->categoria,':marca' => $producto->marca
        ]);
        $id = $this->conexion->lastInsertId();
        $statement = $this->conexion->prepare('SELECT productos.id AS id, productos.nombre AS nombre, productos.precio AS precio, productos.imagen as imagen, marcas.nombre AS marca from productos INNER JOIN marcas ON productos.marca = marcas.id WHERE productos.id = :id');
        $statement->execute(array(':id' => $id));
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function leerProductos() {
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT productos.id AS id, productos.nombre AS nombre, productos.precio AS precio, marcas.nombre AS marca ,productos.imagen AS imagen from productos INNER JOIN marcas ON productos.marca = marcas.id');
        $statement->execute();
        $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function borrarProducto ($producto){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('DELETE FROM productos WHERE id = :id');
        $statement->execute([':id' => $producto->id]);
        return $producto->id;
    }

    public function editarProducto ($producto){        
        $nombreImagen = $this->setImagen($producto->imagen);
        $statement = $this->conexion->prepare('UPDATE productos SET nombre = :nombre, precio = :precio, imagen = :imagen WHERE id = :id'); 
        $statement->execute([
            ':id' => $producto->id, ':nombre' => $producto->nombre,':precio' => $producto->precio,
            ':imagen' => $nombreImagen
        ]);
        $statement = $this->conexion->prepare('SELECT productos.id AS id, productos.nombre AS nombre, productos.precio AS precio, productos.imagen as imagen, marcas.nombre AS marca from productos INNER JOIN marcas ON productos.marca = marcas.id WHERE productos.id = :id');
        $statement->execute(array(':id' => $producto->id));
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function getProducto ($id){
        $conexion = $this->conexion;  
        $statement = $conexion->prepare('SELECT productos.id AS id,productos.nombre AS nombre,
        productos.precio AS precio,marcas.id AS idMarca,
        (SELECT CONCAT( "[",GROUP_CONCAT(JSON_OBJECT("id",marcas.id,"nombre",marcas.nombre)),"]" )) AS marcas 
        FROM productos INNER JOIN marcas ON productos.marca = marcas.id WHERE productos.id = :id'
        );
        $statement->execute([':id' => $id ]);
        $resultados = $statement->fetch(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function setImagen($foto){
        $check = @getimagesize($foto['tmp_name']);
        if($check !== false){
            $carpeta_destino = '../config/img/';
            $archivo_subido = $carpeta_destino . $foto['name'];
            move_uploaded_file($foto['tmp_name'], $archivo_subido);
            return $foto['name'];
        }else{
            return "default_img.png";
        }
    }
}