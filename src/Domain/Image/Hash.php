<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Hash
{
    private const SHA1_LENGTH = 40;

    /** @var string */
    private $hash;

    public function __construct(string $hash)
    {
        $length = strlen($hash);

        if ($length !== self::SHA1_LENGTH) {
            throw new InvalidArgument('Invalid hash', InvalidArgument::CODE_HASH);
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
