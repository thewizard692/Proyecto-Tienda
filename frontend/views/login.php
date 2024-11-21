<?php
session_start();
require_once '.../src/controllers/cuentaController.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $controller = new cuentaController();
    $controller->iniciarSesion($_POST);
    
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <h3 class="text-center mb-4">Iniciar Sesión</h3>
                <form action="" method="post">
                    <div class="mb-3">
                       <label for="usuario" class="form-label">Usuario</label>
                       <input type="text" class="form-control" required name="usuario" placeholder="Nombre de usuario">
                    </div>
                    <div class="mb-3">
                       <label for="password" class="form-label">Contraseña</label>
                       <input type="password" class="form-control" required name="password" placeholder="Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    
                    <?php if (!empty($error)): ?>
                      <div class="alert alert-danger mt-3">
                        <?php echo $error; ?>
                      </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>