<?php

declare(strict_types=1);

use Radarlog\Doop\Infrastructure\Kernel;
use Symfony\Component\HttpFoundation\Request;

[$appEnv, $appDebug] = require_once __DIR__ . '/../bootstrap.php';

$kernel = new Kernel($appEnv, $appDebug);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
