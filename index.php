<?php
require_once __DIR__ . '/core/bootstrap.php';
require_once __DIR__ . '/core/router.class.php';
require_once __DIR__ . '/core/request.php';
require_once __DIR__ . '/app/exceptions/appException.php';
require_once __DIR__ . '/app/exceptions/notFoundException.php';

// Crea el objeto Router
$router = new Router();

// Cargar las rutas
require 'app/routes.php';

// Configuración
$config = require_once __DIR__ . '/app/config.php';
App::bind('config', $config);

// Llama a la ruta correspondiente
try {
    require Router::load('app/routes.php')->direct(Request::uri());
} catch (NotFoundException $notFoundException) {
    die($notFoundException->getMessage());
}
