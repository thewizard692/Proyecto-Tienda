<?php
    interface IUsuario {
        public function agregarAlCarrito($idproducto, $usuarioId);
        public function quitarDelCarrito($idproducto, $usuarioId);
        public function obtenerProductos();
        public function obtenerProductosPorNombre($nombre);
        public function obtenerProductosPorCategoria($categoria);
    }
?>
