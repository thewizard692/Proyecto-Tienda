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
    
    public function crearOrden($usuarioId, $vendedorId)
    {
        $this->conn->beginTransaction();

        $sqlOrden = "INSERT INTO ordenes (ord_vendedor, ord_cliente, ord_fecha_pedido, ord_fecha_entrega)
                     VALUES (:vendedorid, :clienteid, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
        $stmtOrden = $this->conn->prepare($sqlOrden);
        $stmtOrden->bindParam(':vendedorid', $vendedorId);
        $stmtOrden->bindParam(':clienteid', $usuarioId);
        $stmtOrden->execute();

        $ordenId = $this->conn->lastInsertId();

        $sqlCarrito = "SELECT c.productoid, c.cantidad, p.prd_precio
                       FROM carrito c
                       JOIN productos p ON c.productoid = p.idproducto
                       WHERE c.usuarioid = :usuarioid";
        $stmtCarrito = $this->conn->prepare($sqlCarrito);
        $stmtCarrito->bindParam(':usuarioid', $usuarioId);
        $stmtCarrito->execute();

        while ($producto = $stmtCarrito->fetch(PDO::FETCH_ASSOC)) {
            $sqlOrdenProducto = "INSERT INTO orden_productos (orpd_fk_orden_id, orpd_idproducto, orpd_cantidad)
                                 VALUES (:ordenid, :productoid, :cantidad)";
            $stmtOrdenProducto = $this->conn->prepare($sqlOrdenProducto);
            $stmtOrdenProducto->bindParam(':ordenid', $ordenId);
            $stmtOrdenProducto->bindParam(':productoid', $producto['productoid']);
            $stmtOrdenProducto->bindParam(':cantidad', $producto['cantidad']);
            $stmtOrdenProducto->execute();
        }

        $sqlEliminarCarrito = "DELETE FROM carrito WHERE usuarioid = :usuarioid";
        $stmtEliminarCarrito = $this->conn->prepare($sqlEliminarCarrito);
        $stmtEliminarCarrito->bindParam(':usuarioid', $usuarioId);
        $stmtEliminarCarrito->execute();

        $this->conn->commit();

        return ['status' => 'success', 'message' => 'Orden creada correctamente.'];
    }

}
?>