<?php

declare(strict_types=1);

namespace Radarlog\Doop\Infrastructure\Http;

use Symfony\Component\HttpFoundation;

interface Controller
{
    public function __invoke(HttpFoundation\Request $request): HttpFoundation\Response;
}
