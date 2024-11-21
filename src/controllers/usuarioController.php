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

    public function agregarAlCarrito($idproducto, $idusuario){
      return $this->usuarioRepository->agregarAlCarrito($idproducto, $idusuario);
    }

    public function quitarDelCarrito($idproducto, $idusuario){
      return $this->usuarioRepository->quitarDelCarrito($idproducto, $idusuario);
    }

  }
?>