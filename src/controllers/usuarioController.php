<?php
  require_once BASE_PATH . '/repositories/usuarioRepository.php';
  require_once BASE_PATH . '/models/productoModel.php';

  class UsuarioController {
    private $usuarioRepository;

    public function __construct() {
      $this->usuarioRepository = new usuarioRepository();
    }

    public function obtenerProductos() {
      return $this->usuarioRepository->obtenerProductos();
    }

    public function obtenerProductosPorBusqueda($busqueda) {
      return $this->usuarioRepository->obtenerProductosPorBusqueda($busqueda['busqueda']);
    }

    public function obtenerProductosPorCategoria($id) {
      return $this->usuarioRepository->obtenerProductosPorCategoria($id['id']);
    }

    //Nueva funcion de carrito para cale nomas
    //no toma la clase carrito
    public function agregarAlCarrito($usuarioId, $idproducto, $cantidad = 1){
           $carrito = new Carrito();
           $carrito->car_fk_usuario = $usuarioId['car_fk_usuario'];
           $carrito->car_fk_producto = $idproducto['car_fk_usuario'];
           return this->usuarioRepository->agregarAlCarrito($carrito);
    }
    public function quitarDelCarrito($idproducto, $usuarioId){
      return $this->usuarioRepository->quitarDelCarrito($idproducto, $usuarioId);
    }

    public function obtenerCarritoPorUsuario($usuarioId){
      return $this->usuarioRepository->obtenerCarritoPorUsuario($usuarioId);
    }

    public function crearOrden($usuarioId, $vendedorId){
      return $this->usuarioRepository->crearOrden($usuarioId, $vendedorId);
    }

  }
?>