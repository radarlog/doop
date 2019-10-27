<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Radarlog\Doop\Domain;
use Ramsey\Uuid;

final class Identity implements Domain\Identity
{
    /** @var string */
    private $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(?string $uuid = null)
    {
        $uuid = $uuid ?? $this->new();

        if (!Uuid\Uuid::isValid($uuid)) {
            throw new InvalidArgument('Invalid UUID', InvalidArgument::CODE_UUID);
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
