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
require_once BASE_PATH . '/controllers/productoController.php';
require_once BASE_PATH . '/middleware/authMiddleware.php';

$router = new SimpleRouter();
$productoController = new ProductoController();

//*******VENDEDOR**********
$router->post('/vendedor', function() use ($productoController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->crearProducto($data));
});

$router->put('/vendedor', function() use ($productoController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->actualizarProducto($data));
});

$router->delete('/vendedor', function() use ($productoController) {
      $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->borrarProducto($id));
});

$router->get('/vendedor', function() use ($productoController) {
    return json_encode($productoController->obtenerProductos());
});

$router->post('/vendedor/detalle', function() use ($productoController) {
    $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->obtenerProductoPorId($id));
});



//*******USUARIO**********
$router->get('/usuario', function() use ($productoController) {
    return json_encode($productoController->obtenerProductos());
});

$router->get('/usuario', function() use ($productoController) {
    return json_encode($productoController->obtenerProductosPorBusqueda());
});

$router->get('/usuario', function() use ($productoController) {
    return json_encode($productoController->obtenerProductosPorCategoria());
});

$router->get('/usuario', function() use ($productoController) {
    return json_encode($productoController->agregarAlCarrito());
});

$router->get('/usuario', function() use ($productoController) {
    return json_encode($productoController->quitarDelCarrito());
});

$router->dispatch();
?>
