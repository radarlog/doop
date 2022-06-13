<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

final class Uuid implements \Stringable
{
    readonly private string $uuid;

    public function __construct(string $uuid)
    {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/D', $uuid) !== 1) {
            throw InvalidArgument::uuid($uuid);
        }

        $this->uuid = $uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
