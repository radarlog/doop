<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Query;

use Radarlog\Doop\Domain\Image;

final class HashName
{
    private Image\Hash $hash;

    private Image\Name $name;

    public function __construct(string $hash, string $name)
    {
        $this->hash = new Image\Hash($hash);
        $this->name = new Image\Name($name);
    }

    public function hash(): Image\Hash
    {
        return $this->hash;
    }

    public function name(): Image\Name
    {
        return $this->name;
    }
}
