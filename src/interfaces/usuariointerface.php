<?php
    interface IUsuario {
        public function agregarAlCarrito($idproducto, $idusuario);
        public function quitarDelCarrito($idproducto, $idusuario);
        public function obtenerProductos();
        public function obtenerProductosPorNombre($nombre);
        public function obtenerProductosPorCategoria($categoria);
    }
?>
