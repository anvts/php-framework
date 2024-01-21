<?php

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Anvts\Framework\Http\Request;
use Anvts\Framework\Http\Kernel;

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);
$response->send();
