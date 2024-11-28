<?php
    interface ICuenta {
        public function crearUsuario($data);
        public function iniciarSesion($data);
        public function actualizarUsuario($data);
        public function borrarUsuario($usuarioId);
        public function obtenerUsuarioPorId($usuarioId);
    }
?>
