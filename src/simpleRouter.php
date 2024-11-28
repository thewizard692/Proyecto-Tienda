<?php
    class SimpleRouter {
        private $routes = [];

        public function get($path, $callback) {
            $this->routes['GET'][$path] = $callback;
        }
    
        public function post($path, $callback) {
            $this->routes['POST'][$path] = $callback;
        }
    
        public function put($path, $callback) { 
            $this->routes['PUT'][$path] = $callback;
        }
    
        public function delete($path, $callback) { 
            $this->routes['DELETE'][$path] = $callback;
        }

        public function dispatch(){
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $requestUrl = str_replace('/Proyecto-Tienda/src/index.php', '', $requestUrl);

            foreach ($this->routes[$requestMethod] as $path => $callback) {
                if($requestUrl == $path) {
                    echo call_user_func($callback);
                    return;
                }
            }
            http_response_code(404);
            echo json_encode(['error'=>'Not Found']);
        }
    }
?>