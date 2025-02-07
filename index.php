<?php
use sergio\app\exceptions\NotFoundException;
use sergio\core\Request;
use sergio\core\App;
use sergio\Core\Router;

use function sergio\app\getConfig;

require_once __DIR__ . '/vendor/autoload.php';

// Crea el objeto Router
$router = new Router();

// Cargar las rutas
require_once __DIR__ . '/app/config.php';


// Configuración
$config = getConfig();
App::bind('config', $config);

// Llama a la ruta correspondiente
try {
    require Router::load('app/routes.php')->direct(Request::uri());
} catch (NotFoundException $notFoundException) {
    die($notFoundException->getMessage());
}
