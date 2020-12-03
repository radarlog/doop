<?php

declare(strict_types=1);

use Radarlog\Doop\Infrastructure\Kernel;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../bootstrap.php';

// phpcs:disable SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable

$trustedProxies = $_ENV['TRUSTED_PROXIES'] ?? false;
$trustedHosts = $_ENV['TRUSTED_HOSTS'] ?? false;

if ($trustedProxies) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts) {
    Request::setTrustedHosts([$trustedHosts]);
}

$kernel = new Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
