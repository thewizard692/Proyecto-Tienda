<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/usuariointerface.php';

class usuarioRepository implements IUsuario
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
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
        $resultado->bindParam(':nombre', $nombre);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorCategoria($categoria)
    {
        $sql = "SELECT * FROM Productos WHERE prd_categoria = :categoria";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':categoria', $categoria);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarAlCarrito($idproducto, $usuarioId)
    {
        $sql = "INSERT INTO carrito (car_fk_producto, car_fk_usuario) VALUES (:idproducto, :idusuario)";
        $resultado = $this->conn->prepare($sql);

        $resultado->bindParam(':idproducto', $idproducto);
        $resultado->bindParam(':idusuario', $usuarioId);

        if ($resultado->execute()) {
            return ['mensaje' => 'Producto agregado al carrito'];
        } else {
            return ['mensaje' => 'Error al agregar el producto al carrito.'];
        }
    }

    public function quitarDelCarrito($idproducto, $usuarioId)
    {
        $sql = "DELETE FROM Carrito WHERE car_fk_producto = :idproducto AND car_fk_usuario = :idusuario";
        $resultado = $this->conn->prepare($sql);

        $resultado->bindParam(':idproducto', $idproducto);
        $resultado->bindParam(':idusuario', $usuarioId);

        if ($resultado->execute()) {
            return ['mensaje' => 'Producto eliminado del carrito'];
        } else {
            return ['mensaje' => 'Error al eliminar el producto del carrito.'];
        }
    }

    public function obtenerCarritoPorUsuario($usuarioId)
    {
        $sql = "SELECT p.prd_id, p.prd_nombre, p.prd_precio, c.cardet_cantidad
                FROM Productos p
                JOIN Carrito c ON p.prd_id = c.car_fk_producto
                WHERE c.car_fk_usuario = :idusuario";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idusuario', $usuarioId);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>