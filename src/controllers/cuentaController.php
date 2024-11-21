<?php
  require BASE_PATH . '/repositories/cuentaRepository.php';
  require BASE_PATH . '/models/usuarioModel.php';

  class CuentaController {
    private $cuentaRepository;

    public function __construct() {
      $this->cuentaRepository = new cuentaRepository();
    }

    public function crearUsuario($data) {
      $usuario = new Usuario();
      $usuario->usr_nombre = $data['nombre'];
      $usuario->usr_apaterno  = $data['apaterno'];
      $usuario->usr_amaterno = $data['amaterno'];
      $usuario->usr_usuario = $data['usuario'];
      $usuario->usr_psword = password_hash($data['password'], PASSWORD_BCRYPT);
      $usuario->usr_correo = $data['correo'];
      $usuario->usr_telefono = $data['telefono'];
      $usuario->usr_direccion = $data['direccion'];
      return $this->cuentaRepository->crearUsuario($usuario);
    }

    public function iniciarSesion($data) {
        $usuario = $data['usuario'];
        $password = $data['password'];

        $busca = 'SELECT * FROM usuarios WHERE usr_usuario = ?';
        $prep = $this->conexion->prepare($busca);
        $prep->bind_param('s', $usuario);
        $prep->execute();
        $resultado = $prep->get_result();

        if ($resultado->num_rows > 0) {
            $dato = $resultado->fetch_assoc();

            if (password_verify($password, $dato['usr_psword'])) {
        
                $_SESSION['usuario'] = $dato['usr_usuario'];
                $_SESSION['nombre'] = $dato['usr_nombre'];

                echo "<script>
                        alert('¡Bienvenido! Has iniciado sesión correctamente.');
                        window.location.href = 'index.html';
                      </script>";
                exit();
            } else {
                $error = 'Contraseña incorrecta';
            }
        } else {
            $error = 'Usuario no encontrado';
        }

        if (isset($error)) {
            echo "<script>alert('$error');</script>";
        }
    }
    
    public function actualizarUsuario($data) {
      $usuario = new usuario();
      $usuario->prd_idusuario = $data['idusuario'];
      $usuario->prd_nombre = $data['nombre'];
      $usuario->prd_descripcion = $data['descripcion'];
      $usuario->prd_marca = $data['marca'];
      $usuario->prd_estado = $data['estado'];
      $usuario->prd_categoria = $data['categoria'];
      return $this->cuentaRepository->actualizarusuario($usuario);
    }

    public function borrarUsuario($usr_id) {
      return $this->cuentaRepository->borrarusuario($usr_id['id']);
    }

    public function obtenerusuarioPorId($usr_id) {
      return $this->cuentaRepository->obtenerusuarioPorId($usr_id['id']);
    }
  }
?>