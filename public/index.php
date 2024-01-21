<?php

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use Anvts\Framework\Http\Request;

$request = Request::createFromGlobals();

dd($request);