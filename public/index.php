<?php

define('BASE_PATH', dirname(path: __DIR__));

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Anvts\Framework\Http\Kernel;
use Anvts\Framework\Http\Request;
use Anvts\Framework\Routing\Router;

$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

$router = new Router();
$kernel = new Kernel($router);

$response = $kernel->handle($request);
$response->send();
