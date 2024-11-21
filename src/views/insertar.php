<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre = trim($_POST['usr_nombre']);
    $apaterno = trim($_POST['usr_apaterno']);
    $amaterno = trim($_POST['usr_amaterno']);
    $usuario = trim($_POST['usr_usuario']);
    $password = password_hash($_POST['usr_psword'], PASSWORD_BCRYPT);
    $correo = trim($_POST['usr_correo']);
    $telefono = trim($_POST['usr_telefono']);
    $direccion = trim($_POST['usr_direccion']);

    // Validar si el usuario ya existe
    $sql_usuario = "SELECT * FROM usuarios WHERE usr_usuario = ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    if (!$stmt_usuario) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt_usuario->bind_param('s', $usuario);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows > 0) {
        // Redirigir con mensaje de error si el usuario ya existe
        header('Location: index.html?error=usuario_existe');
        exit();
    }

    // Insertar el nuevo usuario
    $sql_insertar = "INSERT INTO usuarios (usr_nombre, usr_apaterno, usr_amaterno, usr_usuario, usr_psword, usr_correo, usr_telefono, usr_direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insertar = $conexion->prepare($sql_insertar);
    if (!$stmt_insertar) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt_insertar->bind_param('ssssssss', $nombre, $apaterno, $amaterno, $usuario, $password, $correo, $telefono, $direccion);

    if ($stmt_insertar->execute()) {
        // Redirigir con mensaje de éxito
        header('Location: index.html?mensaje=success');
    } else {
        // Redirigir con mensaje de error en la inserción
        header('Location: index.html?error=no_se_pudo_insertar');
    }

    // Cerrar las declaraciones
    $stmt_usuario->close();
    $stmt_insertar->close();
}

// Cerrar la conexión
$conexion->close();
?>
