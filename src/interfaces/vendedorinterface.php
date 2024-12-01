<?php
    interface IVendedor {
        public function crearProducto($producto);
        public function actualizarProducto($producto);
        public function borrarProducto($idproducto);
        public function obtenerProductoPorId($idproducto);
        public function obtenerProductos();
    }
?>