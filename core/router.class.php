<?php
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/../app/exceptions/notFoundException.php';

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Define las rutas del router.
     *
     * @param array $routes
     * @return void
     */
    public function define(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * Busca la ruta correspondiente a la URI.
     *
     * @param string $uri
     * @return string
     * @throws NotFoundException
     */
    public function direct(string $uri): string
    {
        if (array_key_exists($uri, $this->routes)) {
            return $this->routes[$uri];
        }
        throw new NotFoundException("No se ha definido una ruta para la uri solicitada");
    }

    /**
     * Carga las rutas desde un archivo y devuelve una instancia de Router.
     *
     * @param string $file
     * @return Router
     */
    public static function load(string $file): Router
    {
        $router = new Router();
        require $file;
        return $router;
    }
}
