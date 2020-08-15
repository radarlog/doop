<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Ramsey\Uuid\Uuid;

final class Identity
{
    private string $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw InvalidArgument::uuid($uuid);
        }

        $this->uuid = $uuid;
    }

    public static function new(): self
    {
        $uuid = Uuid::uuid4()->toString();

        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
