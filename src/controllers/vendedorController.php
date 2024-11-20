<?php
require_once BASE_PATH . '/repositories/productoRepository.php';
require BASE_PATH . '/models/productoModel.php';

class ProductoController
{
    public $ProductoRepository;

    public function __construct()
    {
        $this->ProductoRepository = new ProductoRepository();
    }

    public function crearProducto($data)
    {
        $producto = new Producto();
        $producto->nombre = $data['nombre'];
        $producto->descripcion = $data['descripcion'];
        $producto->tipo = $data['tipo'];
        $producto->precio = $data['precio'];
        $producto->imagen = $data['imagen'];
        return $this->ProductoRepository->crearProducto($producto);
    }

    public function actualizarProducto($data)
    {
        $producto = new Producto();
        $producto->idproducto = $data['idproducto'];
        $producto->nombre = $data['nombre'];
        $producto->descripcion = $data['descripcion'];
        $producto->tipo = $data['tipo'];
        $producto->precio = $data['precio'];
        $producto->imagen = $data['imagen'];
        return $this->ProductoRepository->actualizarProducto($producto);
    }

    public function borrarProducto($idproducto)
    {
        return $this->ProductoRepository->borrarProducto($idproducto['id']);
    }

    public function obtenerProductos()
    {
        return $this->ProductoRepository->obtenerProductos();
    }

    public function obtenerProductosPorNombre($nombre)
    {
        return $this->ProductoRepository->obtenerProductosPorNombre($nombre);
    }

    public function obtenerProductoPorId($id)
    {
        return $this->ProductoRepository->obtenerProductoPorId($id['id']);
    }
}
?>