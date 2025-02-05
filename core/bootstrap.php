<?php
require_once __DIR__ . '/app.class.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/../app/exceptions/notFoundException.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);
