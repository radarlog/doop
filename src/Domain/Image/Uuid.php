<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Uuid implements \Stringable
{
    public const REGEX = '^[0-9a-f]{8}-[0-9a-f]{4}-7[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\z$';

    private readonly string $uuid;

    public function __construct(string $uuid)
    {
        $pattern = sprintf('/%s/', self::REGEX);

        if (preg_match($pattern, $uuid) !== 1) {
            throw InvalidArgument::uuid($uuid);
        }

        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
