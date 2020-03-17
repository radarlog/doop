<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain;
use Ramsey\Uuid;

final class Identity implements Domain\Identity
{
    private string $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(?string $uuid = null)
    {
        $uuid ??= $this->new();

        if (!Uuid\Uuid::isValid($uuid)) {
            throw InvalidArgument::uuid($uuid);
        }

        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    private function new(): string
    {
        return Uuid\Uuid::uuid4()->toString();
    }
}
