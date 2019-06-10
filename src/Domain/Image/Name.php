<?php
declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Name
{
    private const LENGTH_MIN = 3;
    private const LENGTH_MAX = 255;

    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $length = strlen(trim($name));  // trimmed

        if ($length < self::LENGTH_MIN || $length > self::LENGTH_MAX) {
            throw new InvalidArgument('Invalid name', InvalidArgument::CODE_NAME);
        }

        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
