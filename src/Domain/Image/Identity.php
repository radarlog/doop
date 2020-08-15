<?php

declare(strict_types=1);

namespace Radarlog\Doop\Domain\Image;

use Ramsey;

/** @deprecated */
final class Identity
{
    private Uuid $uuid;

    /**
     * @throws InvalidArgument
     */
    public function __construct(string $uuid)
    {
        $this->uuid = new Uuid($uuid);
    }

    public static function new(): Uuid
    {
        $uuid = Ramsey\Uuid\Uuid::uuid4()->toString();

        return new Uuid($uuid);
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
