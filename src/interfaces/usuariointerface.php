<?php
    interface IUsuario {
        public function agregarAlCarrito($idproducto, $usr_id);
        public function quitarDelCarrito($idproducto, $usr_id);
        public function obtenerProductos();
        public function obtenerProductosPorNombre($nombre);
        public function obtenerProductosPorCategoria($categoria);
    }
?>
