<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/vendedorinterface.php';

class VendedorRepository implements IVendedor
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearProducto($producto)
    {
        $sql = "INSERT INTO productos (nombre,descrip,precio,marca,estado) 
                              VALUES (:nombre,:descrip,:precio,:marca,:estado)";                 
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':nombre',$producto->nombre);
        $resultado->bindParam(':descrip',$producto->descrip);
        $resultado->bindParam(':precio',$producto->precio);
        $resultado->bindParam(':marca',$producto->marca);
        $resultado->bindParam(':estado',$producto->estado);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Creado'];
        } else{
            return ['mensaje' => 'Error al crear el producto.'];
        }
    }

    public function actualizarProducto($producto)
    {
        $sql = "UPDATE productos 
        SET 
        nombre = :nombre,
        descrip= descrip,
        tipo = :tipo,
        precio = :precio, 
        estado = :estado,
         WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$producto->idproducto);
        $resultado->bindParam(':nombre',$producto->nombre);
        $resultado->bindParam(':descrip',$producto->descrip);
        $resultado->bindParam(':precio',$producto->precio);
        $resultado->bindParam(':marca',$producto->marca);
        $resultado->bindParam(':estado',$producto->estado);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Actualizado'];
        } else{
            return ['mensaje' => 'Error al actualizar el producto.'];
        }
    }

    public function borrarProducto($idproducto)
    {
        $sql = "DELETE FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$idproducto);
       
        if($resultado->execute()){
            return ['mensaje' => 'Producto Borrado'];
        } else{
            return ['mensaje' => 'Error al borrar el producto.'];
        }
    }

    public function obtenerProductos()
    {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorNombre($nombre)
    {
        $sql = "SELECT * FROM productos WHERE nombre = :nombre";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':nombre',$nombre->nombre);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($idproducto)
    {
        $sql = "SELECT * FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$idproducto);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}

?>