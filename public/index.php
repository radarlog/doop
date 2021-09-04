<?php

declare(strict_types=1);

use Radarlog\Doop\Infrastructure\Kernel;
use Symfony\Component\HttpFoundation\Request;

['app_env' => $appEnv, 'is_debug' => $isDebug] = require dirname(__DIR__) . '/bootstrap.php';

$kernel = new Kernel($appEnv, $isDebug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
