<?php
  require BASE_PATH . '/repositories/usuarioRepository.php';
  require BASE_PATH . '/models/productoModel.php';

  class UsuarioController {
    private $usuarioRepository;

    public function __construct() {
      $this->usuarioRepository = new usuarioRepository();
    }

    public function obtenerProductos() {
      return $this->usuarioRepository->obtenerProductos();
    }

    public function obtenerProductosPorNombre($nombre) {
      return $this->usuarioRepository->obtenerProductosPorNombre($nombre);
    }

    public function obtenerProductosPorCategoria($id) {
      return $this->usuarioRepository->obtenerProductoPorId($id['id']);
    }

    public function agregarAlCarrito($productoId, $usuarioId){
      return $this->usuarioRepository->agregarAlCarrito($productoId, $usuarioId);
    }

    public function quitarDelCarrito($productoId, $usuarioId){
      return $this->usuarioRepository->quitarDelCarrito($productoId, $usuarioId);
    }

  }
?>