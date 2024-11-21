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
        $sql = "INSERT INTO Productos (prd_nombre, prd_descripcion, prd_tipo, prd_precio, prd_estado, prd_categoria) VALUES (:nombre, :descripcion, :tipo, :precio, :estado,:categoria)";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':nombre',$producto->prd_nombre);
        $resultado->bindParam(':descripcion',$producto->prd_descripcion);
        $resultado->bindParam(':tipo',$producto->prd_tipo);
        $resultado->bindParam(':precio',$producto->prd_precio);
        $resultado->bindParam(':estado',$producto->prd_estado);
        $resultado->bindParam(':categoria',$producto->prd_categoria);
        if($resultado->execute()){
            return ['mensaje' => 'Producto Creado'];
        } else{
            return ['mensaje' => 'Error al crear el producto.'];
        }
    }

    public function actualizarProducto($producto)
    {
        $sql = "UPDATE Productos SET prd_nombre = :nombre, prd_descripcion = :descripcion, prd_tipo = :tipo, prd_precio = :precio, prd_estado =:estado, prd_categoria = :categoria,
         WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$producto->prd_idproducto);
        $resultado->bindParam(':nombre',$producto->prd_nombre);
        $resultado->bindParam(':descripcion',$producto->prd_descripcion);
        $resultado->bindParam(':tipo',$producto->prd_tipo);
        $resultado->bindParam(':precio',$producto->prd_precio);
        $resultado->bindParam(':estado',$producto->prd_estado);
        $resultado->bindParam(':categoria',$producto->prd_categoria);
      

        if($resultado->execute()){
            return ['mensaje' => 'Producto Actualizado'];
        } else{
            return ['mensaje' => 'Error al actualizar el producto.'];
        }
    }

    public function borrarProducto($idproducto)
    {
        $sql = "DELETE FROM Productos WHERE idproducto = :idproducto";
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
        $sql = "SELECT * FROM Productos";
        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorNombre($nombre)
    {
        $sql = "SELECT * FROM Productos WHERE prd_nombre = :nombre";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':nombre',$nombre->nombre);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($id)
    {
        $sql = "SELECT * FROM Productos WHERE idproducto = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id',$id);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}

?>