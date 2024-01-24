<?php

define('BASE_PATH', dirname(path: __DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

use Anvts\Framework\Http\Request;
use Anvts\Framework\Http\Kernel;
use League\Container\Container;

/**
 * @var Container $container
 */
$container = require BASE_PATH . '/config/services.php';

$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();
