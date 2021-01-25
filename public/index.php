<?php

declare(strict_types=1);

use Radarlog\Doop\Infrastructure\Kernel;
use Symfony\Component\HttpFoundation\Request;

[$appEnv, $appDebug] = require_once __DIR__ . '/../bootstrap.php';

// phpcs:disable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable

$trustedProxies = $_ENV['TRUSTED_PROXIES'] ?? false;
$trustedHosts = $_ENV['TRUSTED_HOSTS'] ?? false;

if ($trustedProxies) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($appEnv, $appDebug);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
