<?php
declare(strict_types=1);

namespace Radarlog\Doop\Application\Query\Image;

final class HashName
{
    /** @var string */
    private $hash;

    /** @var string */
    private $name;

    public function __construct(string $hash, string $name)
    {
        $this->hash = $hash;
        $this->name = $name;
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function name(): string
    {
        return $this->name;
    }
}
