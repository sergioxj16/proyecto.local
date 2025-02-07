<?php
namespace sergio\Core;
use sergio\Core\App;

require __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);
