<?php
    interface ICuenta {
        public function crearUsuario($data);
        public function iniciarSesion($data);
        public function actualizarUsuario($data);
        public function borrarUsuario($usr_id);
        public function obtenerUsuarioPorId($usr_id);
    }
?>
