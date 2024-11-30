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
        $sql = "SELECT * FROM productos";
        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorBusqueda($busqueda)
    {
        $sql = "SELECT * FROM productos WHERE prd_nombre LIKE :busqueda";
        $resultado = $this->conn->prepare($sql);
        $busqueda = "%" . $busqueda . "%";
        $resultado->bindParam(':busqueda', $busqueda);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorCategoria($categoria)
    {
        $sql = "SELECT * FROM productos WHERE prd_categoria = :categoria";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':categoria', $categoria);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarAlCarrito($usuarioId, $productoid, $cantidad = 1)
    {
        try {

            $sqlCheck = "SELECT cantidad FROM carrito WHERE usuarioid = :usuarioid AND productoid = :productoid";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':usuarioid', $usuarioId);
            $stmtCheck->bindParam(':productoid', $productoid);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $sqlUpdate = "UPDATE carrito SET cantidad = cantidad + :cantidad WHERE usuarioid = :usuarioid AND productoid = :productoid";
                $stmtUpdate = $this->conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':cantidad', $cantidad);
                $stmtUpdate->bindParam(':usuarioid', $usuarioId);
                $stmtUpdate->bindParam(':productoid', $productoid);
                $stmtUpdate->execute();
            } else {
                $sqlInsert = "INSERT INTO carrito (usuarioid, productoid, cantidad) VALUES (:usuarioid, :productoid, :cantidad)";
                $stmtInsert = $this->conn->prepare($sqlInsert);
                $stmtInsert->bindParam(':usuarioid', $usuarioId);
                $stmtInsert->bindParam(':productoid', $productoid);
                $stmtInsert->bindParam(':cantidad', $cantidad);
                $stmtInsert->execute();
            }
    
            return ['status' => 'success', 'message' => 'Producto agregado o actualizado en el carrito.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al agregar producto al carrito: ' . $e->getMessage()];
        }
    }
    

    public function quitarDelCarrito($usuarioId, $productoid, $cantidad = 1)
    {
        try {
            $sqlCheck = "SELECT cantidad FROM carrito WHERE usuarioid = :usuarioid AND productoid = :productoid";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':usuarioid', $usuarioId);
            $stmtCheck->bindParam(':productoid', $productoid);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $nuevaCantidad = $result['cantidad'] - $cantidad;
    
                if ($nuevaCantidad > 0) {
                    $sqlUpdate = "UPDATE carrito SET cantidad = :cantidad WHERE usuarioid = :usuarioid AND productoid = :productoid";
                    $stmtUpdate = $this->conn->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':cantidad', $nuevaCantidad);
                    $stmtUpdate->bindParam(':usuarioid', $usuarioId);
                    $stmtUpdate->bindParam(':productoid', $productoid);
                    $stmtUpdate->execute();
                } else {
                    $sqlDelete = "DELETE FROM carrito WHERE usuarioid = :usuarioid AND productoid = :productoid";
                    $stmtDelete = $this->conn->prepare($sqlDelete);
                    $stmtDelete->bindParam(':usuarioid', $usuarioId);
                    $stmtDelete->bindParam(':productoid', $productoid);
                    $stmtDelete->execute();
                }
    
                return ['status' => 'success', 'message' => 'Producto actualizado o eliminado del carrito.'];
            } else {
                return ['status' => 'error', 'message' => 'El producto no está en el carrito.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al quitar producto del carrito: ' . $e->getMessage()];
        }
    }
    
    public function obtenerCarritoPorUsuario($usuarioId)
    {
        $sql = "SELECT p.idproducto AS prd_id, p.prd_nombre, p.prd_precio, c.cantidad AS cardet_cantidad
                FROM productos p
                JOIN carrito c ON p.idproducto = c.productoid
                WHERE c.usuarioid = :usuarioid";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':usuarioid', $usuarioId);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>