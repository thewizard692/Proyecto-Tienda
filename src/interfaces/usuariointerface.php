<?php
    interface IUsuario {
        public function agregarAlCarrito(int $idproducto, int $idusuario): array;
        public function quitarDelCarrito(int $idproducto, int $idusuario): array;
        public function obtenerProductos();
        public function obtenerProductosPorNombre($nombre);
        public function obtenerProductosPorCategoria($id);
    }
?>
