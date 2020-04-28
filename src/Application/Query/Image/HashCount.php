<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Query\Image;

use Radarlog\Doop\Domain\Image;

final class HashCount
{
    private Image\Hash $hash;

    private int $count;

    public function __construct(string $hash, int $count)
    {
        $this->hash = new Image\Hash($hash);
        $this->count = $count;
    }

    public function hash(): Image\Hash
    {
        return $this->hash;
    }

    public function count(): int
    {
        return $this->count;
    }
}
