<?php
  define('BASE_PATH', __DIR__);

 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once BASE_PATH . '/simpleRouter.php';
require_once BASE_PATH . '/controllers/VendedorController.php';
require_once BASE_PATH . '/controllers/UsuarioController.php';
require_once BASE_PATH . '/middleware/authMiddleware.php';

$router = new SimpleRouter();
$VendedorController = new VendedorController();
$UsuarioController = new UsuarioController();

//*******VENDEDOR**********
$router->post('/usuario/vendedor', function() use ($VendedorController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->crearProducto($data));
});

$router->put('/usuario/vendedor', function() use ($VendedorController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->actualizarProducto($data));
});

$router->delete('/usuario/vendedor', function() use ($VendedorController) {
      $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->borrarProducto($id));
});

$router->get('/usuario/vendedor', function() use ($VendedorController) {
    return json_encode($VendedorController->obtenerProductos());
});

$router->post('/usuario/vendedor/detalle', function() use ($VendedorController) {
    $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->obtenerProductoPorId($id));
});


//*******USUARIO**********
$router->get('/usuario', function() use ($UsuarioController) {
    return json_encode($VendedorController->obtenerProductos());
});

$router->get('/usuario', function() use ($UsuarioController) {
    return json_encode($VendedorController->obtenerProductosPorNombre());
});

$router->get('/usuario', function() use ($UsuarioController) {
    return json_encode($VendedorController->obtenerProductosPorCategoria());
});

$router->get('/usuario', function() use ($UsuarioController) {
    return json_encode($VendedorController->agregarAlCarrito());
});

$router->get('/usuario', function() use ($UsuarioController) {
    return json_encode($VendedorController->quitarDelCarrito());
});

$router->dispatch();
?>
