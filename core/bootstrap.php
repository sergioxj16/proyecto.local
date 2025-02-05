<?php
require_once __DIR__ . '/app.class.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/../app/exceptions/notFoundException.php';
require __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);
