<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final readonly class Name implements \Stringable
{
    private const int LENGTH_MIN = 3;
    private const int LENGTH_MAX = 255;

    private string $name;

    public function __construct(string $name)
    {
        $length = strlen(trim($name)); // trimmed

        switch (true) {
            case $length < self::LENGTH_MIN:
            case $length > self::LENGTH_MAX:
                throw InvalidArgument::name($name);
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
