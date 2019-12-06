<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Query\Image;

interface FindOne
{
    public function hashNameByUuid(string $uuid): HashName;
}
