<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/usuariointerface.php';

class UsuarioRepository implements IUsuario
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function obtenerProductos()
    {
        try {
            $sql = "SELECT * FROM Productos";
            $resultado = $this->conn->prepare($sql);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }

    public function obtenerProductosPorNombre($nombre)
    {
        try {
            $sql = "SELECT * FROM Productos WHERE prd_nombre = :nombre";
            $resultado = $this->conn->prepare($sql);
            $resultado->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $resultado->execute();
            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }

    public function obtenerProductosPorCategoria($id)
    {
        try {
            $sql = "SELECT * FROM Productos WHERE prd_categoria = :id";
            $resultado = $this->conn->prepare($sql);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }

    public function agregarAlCarrito($producto, $usuarioId)
    {
        try {
            $sql = "INSERT INTO Carrito (car_fk_producto, car_fk_usuario) VALUES (:productoId, :usuarioId)";
            $resultado = $this->conn->prepare($sql);

            $resultado->bindParam(':productoId', $producto->prd_id, PDO::PARAM_INT);
            $resultado->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);

            if ($resultado->execute()) {
                return ['mensaje' => 'Producto agregado al carrito'];
            } else {
                return ['mensaje' => 'Error al agregar el producto al carrito.'];
            }
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }

    public function quitarDelCarrito($productoId, $usuarioId)
    {
        try {
            $sql = "DELETE FROM Carrito WHERE car_fk_producto = :productoId AND car_fk_usuario = :usuarioId";
            $resultado = $this->conn->prepare($sql);

            $resultado->bindParam(':productoId', $productoId, PDO::PARAM_INT);
            $resultado->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);

            if ($resultado->execute()) {
                return ['mensaje' => 'Producto eliminado del carrito'];
            } else {
                return ['mensaje' => 'Error al eliminar el producto del carrito.'];
            }
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }

    public function obtenerCarritoPorUsuario($usuarioId)
    {
        try {
            $sql = "SELECT p.prd_id, p.prd_nombre, p.prd_precio, c.cardet_cantidad
                    FROM Productos p
                    JOIN Carrito c ON p.prd_id = c.car_fk_producto
                    WHERE c.car_fk_usuario = :usuarioId";
            $resultado = $this->conn->prepare($sql);
            $resultado->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['mensaje' => 'Error: ' . $e->getMessage()];
        }
    }
}
?>
