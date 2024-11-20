<?php
  require_once BASE_PATH . '/config/database.php';
  require_once BASE_PATH . '/interfaces/productoInterface.php';

  class ProductoRepository implements IProducto {
    private $conn;

    public function __construct() {
      $database = new Database();
      $this->conn = $database->getConnection();
    }

    public function crearProducto($producto) {
      $sql = "INSERT INTO Productos (prd_nombre, prd_precio, prd_descrip, prd_marca, prd_estado, prd_categoria) 
                                VALUES(:nombre,:precio,:descripcion,:marca, :estado, :categoria)";
      $resultado = $this->conn->prepare($sql);
      $resultado->bindParam(':nombre', $producto->prd_nombre);
      $resultado->bindParam(':precio', $producto->prd_precio);
      $resultado->bindParam(':descripcion', $producto->prd_descripcion);
      $resultado->bindParam(':marca', $producto->prd_marca);
      $resultado->bindParam(':estado', $producto->prd_estado);
      $resultado->bindParam(':categoria', $producto->prd_categoria);

      if ($resultado->execute()) {
        return ['mensaje' => 'Producto Creado'];
      }
      return ['mensaje' => 'Error al crear el producto'];
    }

    public function actualizarProducto($producto) {
      $sql = "UPDATE Productos SET prd_nombre=:nombre, prd_precio=:precio, prd_descrip=:descripcion, prd_marca=:marca,
                                   prd_estado=:estado, prd_categoria=:categoria 
      WHERE idproducto = :idproducto";

      $resultado = $this->conn->prepare($sql);

      $resultado->bindParam(':idproducto', $producto->idproducto);
      $resultado->bindParam(':nombre', $producto->prd_nombre);
      $resultado->bindParam(':precio', $producto->prd_precio);
      $resultado->bindParam(':descripcion', $producto->prd_descripcion);
      $resultado->bindParam(':marca', $producto->prd_marca);
      $resultado->bindParam(':estado', $producto->prd_estado);
      $resultado->bindParam(':categoria', $producto->prd_categoria);

      if ($resultado->execute()) {
        return ['mensaje' => 'Producto Actualizado'];
      }
      return ['mensaje' => 'Error al actualizar el producto'];
    }

    public function borrarProducto($idproducto) {
      $sql = "DELETE FROM Productos WHERE idproducto = :idproducto";
      $resultado = $this->conn->prepare($sql);
      $resultado->bindParam(':idproducto', $idproducto);
      if ($resultado->execute()) {
        return ['mensaje' => 'Producto Borrado'];
      }
      return ['mensaje' => 'Error al borrar el prdocuto'];
    }

    public function obtenerProductos() {
      $sql = "SELECT * FROM Productos";
      $resultado = $this->conn->prepare($sql);
      $resultado->execute();
      return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorNombre($nombre) {
      $sql = "SELECT * FROM Productos WHERE prd_nombre = :nombre";
      $resultado = $this->conn->prepare($sql);
      $resultado->bindParam(':nombre', $nombre);
      $resultado->execute();
      return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($idproducto) {
      $sql = "SELECT * FROM Productos WHERE idproducto = :idproducto";
      $resultado = $this->conn->prepare($sql);
      $resultado->bindParam(':idproducto', $idproducto);
      $resultado->execute();
      return $resultado->fetch(PDO::FETCH_ASSOC);
    }

  }
?>