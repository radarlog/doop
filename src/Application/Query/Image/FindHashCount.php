<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Query\Image;

interface FindHashCount
{
    public function byId(string $id): HashCount;
}
