<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/cuentainterface.php';

    class cuentaRepository implements ICuenta
    {
        private $conn;

        public function __construct()
        {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function crearUsuario($usuario) {
    
            $sql = "INSERT INTO usuarios (usr_nombre, usr_apaterno, usr_amaterno, usr_usuario, usr_psword, usr_correo, usr_telefono, usr_direccion)
                    VALUES (:nombre, :apaterno, :amaterno, :usuario, :password, :correo, :telefono, :direccion)";
            
            $resultado = $this->conn->prepare($sql);
            $resultado->bindParam(':nombre', $usuario->usr_nombre);
            $resultado->bindParam(':apaterno', $usuario->usr_apaterno);
            $resultado->bindParam(':amaterno', $usuario->usr_amaterno);
            $resultado->bindParam(':usuario', $usuario->usr_usuario);
            $resultado->bindParam(':password', $usuario->usr_psword);
            $resultado->bindParam(':correo', $usuario->usr_correo);
            $resultado->bindParam(':telefono', $usuario->usr_telefono);
            $resultado->bindParam(':direccion', $usuario->usr_direccion);
    
            if ($resultado->execute()) {
                return ['mensaje' => 'Usuario creado con éxito'];
            } else {
                return ['mensaje' => 'Error al crear el usuario.'];
            }
        }
        

    public function iniciarSesion($data) {
        return 0;
    }

    public function actualizarUsuario($usuario)
    {
        $sql_usuario = "SELECT * FROM usuarios WHERE usr_usuario = :usuario";
        $stmt_usuario = $this->conn->prepare($sql_usuario);
        $stmt_usuario->bindParam(':usuario', $usuario->usuario);
        $stmt_usuario->execute();
        $result_usuario = $stmt_usuario->fetchAll();
    
        if (count($result_usuario) > 0) {
            return ['mensaje' => 'Error: El usuario ya existe.'];
        }
        
        $sql = "UPDATE usuarios 
                SET usr_nombre = :nombre, 
                    usr_apaterno = :apaterno, 
                    usr_amaterno = :amaterno, 
                    usr_usuario = :usuario, 
                    usr_psword = :password, 
                    usr_correo = :correo, 
                    usr_telefono = :telefono, 
                    usr_direccion = :direccion
                WHERE idusuario = :idusuario";
    
        $resultado = $this->conn->prepare($sql);
    
        $resultado->bindParam(':idusuario', $usuario->idusuario);
        $resultado->bindParam(':nombre', $usuario->nombre);
        $resultado->bindParam(':apaterno', $usuario->apaterno);
        $resultado->bindParam(':amaterno', $usuario->amaterno);
        $resultado->bindParam(':usuario', $usuario->usuario);
        $resultado->bindParam(':password', $usuario->password);
        $resultado->bindParam(':correo', $usuario->correo);
        $resultado->bindParam(':telefono', $usuario->telefono);
        $resultado->bindParam(':direccion', $usuario->direccion);
    
        if ($resultado->execute()) {
            return ['mensaje' => 'Usuario actualizado con éxito'];
        } else {
            return ['mensaje' => 'Error al actualizar el usuario.'];
        }
    }
    
    public function borrarusuario($idusuario)
    {
        $sql = "DELETE FROM usuarios WHERE usr_id = :idusuario";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idusuario',$idusuario);
       
        if($resultado->execute()){
            return ['mensaje' => 'usuario Borrado'];
        } else{
            return ['mensaje' => 'Error al borrar el usuario.'];
        }
    }

    public function obtenerusuarioPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE usr_id = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id',$id);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}

?>