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

    public function obtenerProductosPorNombre($nombre) {
      return $this->usuarioRepository->obtenerProductosPorNombre($nombre);
    }

    public function obtenerProductosPorCategoria($id) {
      return $this->usuarioRepository->obtenerProductosPorCategoria($id['id']);
    }

    public function agregarAlCarrito($idproducto, $usr_id){
      return $this->usuarioRepository->agregarAlCarrito($idproducto, $usr_id);
    }

    public function quitarDelCarrito($idproducto, $usr_id){
      return $this->usuarioRepository->quitarDelCarrito($idproducto, $usr_id);
    }

  }
?>