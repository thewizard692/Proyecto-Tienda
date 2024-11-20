<?php
  require BASE_PATH . '/repositories/productoRepository.php';
  require BASE_PATH . '/models/productoModel.php';

  class ProductoController {
    private $productoRepository;

    public function __construct() {
      $this->productoRepository = new ProductoRepository();
    }

    public function crearProducto($data) {
      $producto = new Producto();
      $producto->prd_nombre = $data['nombre'];
      $producto->prd_descripcion = $data['descripcion'];
      $producto->prd_marca = $data['marca'];
      $producto->prd_estado = $data['estado'];
      $producto->prd_categoria = $data['categoria'];
      //$producto->prd_idpublicacion = $data['idpublicacion'];
      //$producto->prd_idventedor = $data['idvendedor'];
      return $this->productoRepository->crearProducto($producto);
    }

    public function actualizarProducto($data) {
      $producto = new Producto();
      $producto->prd_idproducto = $data['idproducto'];
      $producto->prd_nombre = $data['nombre'];
      $producto->prd_descripcion = $data['descripcion'];
      $producto->prd_marca = $data['marca'];
      $producto->prd_estado = $data['estado'];
      $producto->prd_categoria = $data['categoria'];
      //$producto->prd_idpublicacion = $data['idpublicacion'];
      //$producto->prd_idventedor = $data['idvendedor'];
      return $this->productoRepository->actualizarProducto($producto);
    }

    public function borrarProducto($idproducto) {
      return $this->productoRepository->borrarProducto($idproducto['id']);
    }

    public function obtenerProductos() {
      return $this->productoRepository->obtenerProductos();
    }

    public function obtenerProductosPorNombre($nombre) {
      return $this->productoRepository->obtenerProductosPorNombre($nombre);
    }

    public function obtenerProductoPorId($id) {
      //se tiene que poner $id['id'] para que mande el valor del atributo y no el arreglo completo del id
      return $this->productoRepository->obtenerProductoPorId($id['id']);
    }
  }
?>