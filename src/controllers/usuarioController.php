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
      return $this->usuarioRepository->obtenerProductosPorBusqueda($busqueda);
    }

    public function obtenerProductosPorCategoria($id) {
      return $this->usuarioRepository->obtenerProductosPorCategoria($id['id']);
    }

    public function agregarAlCarrito($idproducto, $usuarioId){
      return $this->usuarioRepository->agregarAlCarrito($idproducto, $usuarioId);
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