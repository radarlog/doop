<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Hash
{
    private const SHA1_LENGTH = 40;

    private string $hash;

    public function __construct(string $hash)
    {
        $length = strlen($hash);

        switch (true) {
            case $length !== self::SHA1_LENGTH:
            case ctype_xdigit($hash) === false:
                throw InvalidArgument::hash($hash);
        }

        $this->hash = strtolower($hash);
    }

    public static function calculate(string $value): self
    {
        $hash = sha1($value);

        return new self($hash);
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
