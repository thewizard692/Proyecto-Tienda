<?php
  require_once BASE_PATH . '/repositories/vendedorRepository.php';
  require_once BASE_PATH . '/models/productoModel.php';

  class VendedorController {
    private $vendedorRepository;

    public function __construct() {
      $this->vendedorRepository = new vendedorRepository();
    }

    public function crearProducto($data) {
      $producto = new Producto();
      $producto->nombre = $data['nombre'];
      $producto->descrip = $data['descripcion'];
      $producto->precio = $data['precio'];
      $producto->marca = $data['marca'];
      $producto->estado = $data['estado'];
      return $this->vendedorRepository->crearProducto($producto);
    }

    public function actualizarProducto($data) {
      $producto = new Producto();
      $producto->idproducto = $data['idproducto'];
      $producto->nombre = $data['nombre'];
      $producto->descrip = $data['descripcion'];
      $producto->precio = $data['precio'];
      $producto->marca = $data['marca'];
      $producto->estado = $data['estado'];
      return $this->vendedorRepository->actualizarProducto($producto);
    }

    public function borrarProducto($idproducto) {
      return $this->vendedorRepository->borrarProducto($idproducto['id']);
    }

    public function obtenerProductos() {
      return $this->vendedorRepository->obtenerProductos();
    }

    public function obtenerProductosPorNombre($nombre) {
      return $this->vendedorRepository->obtenerProductosPorNombre($nombre);
    }

    public function obtenerProductoPorId($id) {
      //se tiene que poner $id['id'] para que mande el valor del atributo y no el arreglo completo del id
      return $this->vendedorRepository->obtenerProductoPorId($id['id']);
    }
  }
?>