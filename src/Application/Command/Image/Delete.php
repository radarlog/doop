<?php

declare(strict_types=1);

namespace Radarlog\Doop\Application\Command\Image;

use Radarlog\Doop\Application\Command;

final class Delete implements Command
{
    private readonly string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function fqcnHandler(): string
    {
        return DeleteHandler::class;
    }

    public function serialize(): array
    {
        return get_object_vars($this);
    }
}
