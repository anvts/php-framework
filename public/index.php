<?php

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Anvts\Framework\Http\Request;
use Anvts\Framework\Http\Response;

$request = Request::createFromGlobals();

$content = '<h1>Test</h1>';

$response = new Response($content);
$response->send();
